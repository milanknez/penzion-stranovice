<?php
/**
 * Frontend Contact & Reservation Form Handler
 * Object-Oriented implementation protected by Spam filter plugin
 */

require_once __DIR__ . '/admin/includes/CMS.php';

class ContactFormHandler {
    private array $data;
    private array $siteConfig;
    private string $siteName;
    private string $recipient;

    public function __construct(?array $postData = null) {
        $this->data = $postData ?? $_POST;
        CMS::loadActivePlugins();
        $this->siteConfig = CMS::getSiteConfig();
        $this->siteName = $this->siteConfig['site_name'] ?? 'Statek Straňovice';
        $this->recipient = $this->resolveRecipient();
    }

    /**
     * Main execution pipeline.
     */
    public function handle(): void {
        $this->setHeaders();
        $this->validateRequestMethod();
        $this->verifyAntispam();
        $this->validateInput();
        $this->dispatchEmail();
    }

    /**
     * Set JSON response header.
     */
    private function setHeaders(): void {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
        }
    }

    /**
     * Ensure only POST requests are processed.
     */
    private function validateRequestMethod(): void {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $this->respond(false, 'Povoleny jsou pouze POST požadavky.', 405);
        }
    }

    /**
     * Verify Spam filter protection if plugin is installed and active.
     */
    private function verifyAntispam(): void {
        if (class_exists('SpamFilterPlugin')) {
            $verifyResult = SpamFilterPlugin::verifySubmission($this->data);
            if (empty($verifyResult['success'])) {
                $this->respond(false, $verifyResult['message'] ?? 'Bezpečnostní ověření formuláře selhalo.', 400);
            }
        }
    }

    /**
     * Validate mandatory user fields.
     */
    private function validateInput(): void {
        $name = trim($this->data['jmeno'] ?? $this->data['name'] ?? '');
        $email = trim($this->data['email'] ?? '');

        if (empty($name)) {
            $this->respond(false, 'Prosím vyplňte vaše jméno a příjmení.', 422);
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->respond(false, 'Prosím zadejte platnou e-mailovou adresu.', 422);
        }
    }

    /**
     * Resolve target recipient email from site configuration.
     */
    private function resolveRecipient(): string {
        $rec = $this->siteConfig['contact_form_recipient'] ?? $this->siteConfig['email'] ?? 'info@statekstranovice.cz';
        return !empty($rec) ? $rec : 'info@statekstranovice.cz';
    }

    /**
     * Build appropriate subject line based on inquiry type.
     */
    private function buildSubject(): string {
        $name = trim($this->data['jmeno'] ?? $this->data['name'] ?? '');
        $room = trim($this->data['room'] ?? '');
        $arrival = trim($this->data['prijezd'] ?? '');

        $isReservation = !empty($room) || !empty($arrival);
        return $isReservation 
            ? "Nová rezervace: " . ($room ?: "Penzion") . " – " . $name
            : "Nová zpráva z webu " . $this->siteName . " – " . $name;
    }

    /**
     * Build responsive HTML email template.
     */
    private function buildHtmlContent(string $subject): string {
        $name = trim($this->data['jmeno'] ?? $this->data['name'] ?? '');
        $email = trim($this->data['email'] ?? '');
        $phone = trim($this->data['telefon'] ?? $this->data['phone'] ?? '');
        $room = trim($this->data['room'] ?? '');
        $arrival = trim($this->data['prijezd'] ?? '');
        $departure = trim($this->data['odjezd'] ?? '');
        $guests = trim($this->data['pocet_hostu'] ?? '');
        $message = trim($this->data['zprava'] ?? $this->data['message'] ?? '');
        $isReservation = !empty($room) || !empty($arrival);

        $html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>' . htmlspecialchars($subject) . '</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background-color: #f8fafc; color: #1e293b; padding: 24px 12px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <div style="background: #1e293b; padding: 24px; text-align: center; border-bottom: 3px solid #c99e66;">
            <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-family: \'Libre Baskerville\', Georgia, serif;">' . htmlspecialchars($this->siteName) . '</h1>
            <p style="color: #c99e66; font-size: 13px; margin: 6px 0 0 0; font-weight: 600;">' . ($isReservation ? 'Nová poptávka rezervace apartmánu' : 'Nová zpráva z kontaktního formuláře') . '</p>
        </div>
        <div style="padding: 24px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b; width: 140px;"><strong>Jméno a příjmení:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a; font-weight: 600;">' . htmlspecialchars($name) . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>E-mail:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a;"><a href="mailto:' . htmlspecialchars($email) . '" style="color: #2563eb; text-decoration: none;">' . htmlspecialchars($email) . '</a></td>
                </tr>';

        if (!empty($phone)) {
            $html .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Telefon:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a;"><a href="tel:' . htmlspecialchars($phone) . '" style="color: #2563eb; text-decoration: none;">' . htmlspecialchars($phone) . '</a></td>
                </tr>';
        }

        if (!empty($room)) {
            $html .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Apartmán:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #b45309; font-weight: 700;">' . htmlspecialchars($room) . '</td>
                </tr>';
        }

        if (!empty($arrival) || !empty($departure)) {
            $html .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Termín pobytu:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a;">' . htmlspecialchars($arrival) . ' &rarr; ' . htmlspecialchars($departure) . '</td>
                </tr>';
        }

        if (!empty($guests)) {
            $html .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Počet hostů:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a;">' . htmlspecialchars($guests) . '</td>
                </tr>';
        }

        if (!empty($message)) {
            $html .= '
                <tr>
                    <td style="padding: 12px 0 6px 0; color: #64748b; vertical-align: top;"><strong>Zpráva / poznámka:</strong></td>
                    <td style="padding: 12px 0 6px 0; color: #0f172a; white-space: pre-line; line-height: 1.5;">' . nl2br(htmlspecialchars($message)) . '</td>
                </tr>';
        }

        $html .= '
            </table>
        </div>
        <div style="background: #f8fafc; padding: 16px 24px; border-top: 1px solid #e2e8f0; font-size: 11px; color: #94a3b8; display: flex; justify-content: space-between;">
            <span>Odesláno: ' . date('d.m.Y H:i:s') . '</span>
            <span>IP: ' . htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') . '</span>
        </div>
    </div>
</body>
</html>';

        return $html;
    }

    /**
     * Build standard email headers.
     */
    private function buildHeaders(): array {
        $name = trim($this->data['jmeno'] ?? $this->data['name'] ?? '');
        $email = trim($this->data['email'] ?? '');
        $fromEmail = $this->siteConfig['email'] ?? 'noreply@statekstranovice.cz';

        return [
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $this->siteName . ' <' . $fromEmail . '>',
            'Reply-To: ' . $name . ' <' . $email . '>',
            'X-Mailer: Statek Stranovice CMS (OOP FormHandler)'
        ];
    }

    /**
     * Send email via CMS mailer abstraction.
     */
    private function dispatchEmail(): void {
        $subject = $this->buildSubject();
        $html = $this->buildHtmlContent($subject);
        $headers = $this->buildHeaders();

        $sent = CMS::sendMail($this->recipient, $subject, $html, implode("\r\n", $headers));

        if ($sent) {
            $this->respond(true, 'Děkujeme! Vaše poptávka byla v pořádku odeslána. Brzy se vám ozveme.');
        } else {
            $this->respond(false, 'Zprávu se nepodařilo odeslat. Zkontrolujte prosím konfiguraci e-mailového serveru nebo nás kontaktujte telefonicky.', 500);
        }
    }

    /**
     * Emit standardized JSON response.
     */
    private function respond(bool $success, string $message, int $statusCode = 200): void {
        if (!headers_sent()) {
            http_response_code($statusCode);
        }
        echo json_encode([
            'success' => $success,
            'message' => $message
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// Instantiate and handle incoming request
$formHandler = new ContactFormHandler();
$formHandler->handle();
