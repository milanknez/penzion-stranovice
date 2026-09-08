<?php
/**
 * Frontend Contact & Reservation Form Handler
 * Protected by Spam filter plugin
 */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Povoleny jsou pouze POST požadavky.']);
    exit;
}

require_once __DIR__ . '/admin/includes/CMS.php';
CMS::loadActivePlugins();

// 1. Antispam verification (if Spam filter plugin is active)
if (class_exists('SpamFilterPlugin')) {
    $verifyResult = SpamFilterPlugin::verifySubmission($_POST);
    if (empty($verifyResult['success'])) {
        echo json_encode([
            'success' => false,
            'message' => $verifyResult['message'] ?? 'Bezpečnostní ověření formuláře selhalo.'
        ]);
        exit;
    }
}

// 2. Validate required fields
$name = trim($_POST['jmeno'] ?? $_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['telefon'] ?? $_POST['phone'] ?? '');
$room = trim($_POST['room'] ?? '');
$arrival = trim($_POST['prijezd'] ?? '');
$departure = trim($_POST['odjezd'] ?? '');
$guests = trim($_POST['pocet_hostu'] ?? '');
$message = trim($_POST['zprava'] ?? $_POST['message'] ?? '');

if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Prosím vyplňte vaše jméno a příjmení.']);
    exit;
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Prosím zadejte platnou e-mailovou adresu.']);
    exit;
}

// 3. Resolve recipient email from site configuration
$siteConfig = CMS::getSiteConfig();
$recipient = $siteConfig['contact_form_recipient'] ?? $siteConfig['email'] ?? 'info@statekstranovice.cz';
if (empty($recipient)) {
    $recipient = 'info@statekstranovice.cz';
}

$siteName = $siteConfig['site_name'] ?? 'Statek Straňovice';

// 4. Construct email subject and content
$isReservation = !empty($room) || !empty($arrival);
$subject = $isReservation 
    ? "Nová rezervace: " . ($room ? $room : "Penzion") . " – " . $name
    : "Nová zpráva z webu " . $siteName . " – " . $name;

$htmlContent = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>' . htmlspecialchars($subject) . '</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background-color: #f8fafc; color: #1e293b; padding: 24px 12px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <div style="background: #1e293b; padding: 24px; text-align: center; border-bottom: 3px solid #c99e66;">
            <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-family: \'Libre Baskerville\', Georgia, serif;">' . htmlspecialchars($siteName) . '</h1>
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
    $htmlContent .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Telefon:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a;"><a href="tel:' . htmlspecialchars($phone) . '" style="color: #2563eb; text-decoration: none;">' . htmlspecialchars($phone) . '</a></td>
                </tr>';
}

if (!empty($room)) {
    $htmlContent .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Apartmán:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #b45309; font-weight: 700;">' . htmlspecialchars($room) . '</td>
                </tr>';
}

if (!empty($arrival) || !empty($departure)) {
    $htmlContent .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Termín pobytu:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a;">' . htmlspecialchars($arrival) . ' &rarr; ' . htmlspecialchars($departure) . '</td>
                </tr>';
}

if (!empty($guests)) {
    $htmlContent .= '
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #64748b;"><strong>Počet hostů:</strong></td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #0f172a;">' . htmlspecialchars($guests) . '</td>
                </tr>';
}

if (!empty($message)) {
    $htmlContent .= '
                <tr>
                    <td style="padding: 12px 0 6px 0; color: #64748b; vertical-align: top;"><strong>Zpráva / poznámka:</strong></td>
                    <td style="padding: 12px 0 6px 0; color: #0f172a; white-space: pre-line; line-height: 1.5;">' . nl2br(htmlspecialchars($message)) . '</td>
                </tr>';
}

$htmlContent .= '
            </table>
        </div>
        <div style="background: #f8fafc; padding: 16px 24px; border-top: 1px solid #e2e8f0; font-size: 11px; color: #94a3b8; display: flex; justify-content: space-between;">
            <span>Odesláno: ' . date('d.m.Y H:i:s') . '</span>
            <span>IP: ' . htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') . '</span>
        </div>
    </div>
</body>
</html>';

$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . $siteName . ' <' . ($siteConfig['email'] ?? 'noreply@statekstranovice.cz') . '>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'X-Mailer: Statek Stranovice CMS'
];

// 5. Send mail via CMS
$sent = CMS::sendMail($recipient, $subject, $htmlContent, implode("\r\n", $headers));

if ($sent) {
    echo json_encode([
        'success' => true,
        'message' => 'Děkujeme! Vaše poptávka byla v pořádku odeslána. Brzy se vám ozveme.'
    ]);
} else {
    // If sending failed, provide informative response
    echo json_encode([
        'success' => false,
        'message' => 'Zprávu se nepodařilo odeslat. Zkontrolujte prosím konfiguraci e-mailového serveru nebo nás kontaktujte telefonicky.'
    ]);
}
