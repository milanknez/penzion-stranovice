<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/AuthManager.php';
$_SESSION['logged_in'] = true;
$_GET['lang'] = 'cs';
$_GET['page'] = '404.php';
$_GET['view'] = 'editor';

ob_start();
include __DIR__ . '/index.php';
$html = ob_get_clean();

$lines = explode("\n", $html);

header('Content-Type: text/plain; charset=utf-8');

echo "Checking rendered HTML (" . count($lines) . " lines) for JS syntax error patterns...\n\n";

$patterns = [
    'Empty catch parens: catch ()' => '/catch\s*\(\s*\)/i',
    'Trailing comma before paren: , )' => '/,\s*\)/',
    'Comma right after open paren: ( ,' => '/\(\s*,/',
    'Double comma: , ,' => '/,\s*,/',
    'Arrow without body or expr: => )' => '/=>\s*\)/',
    'Dot before paren: . )' => '/\.\s*\)/',
    'Empty parameter arrow: () =>' => '/\(\s*\)\s*=>/',
    'Single param arrow: \w+ =>' => '/\b\w+\s*=>/',
];

foreach ($patterns as $name => $regex) {
    echo "=== {$name} ===\n";
    $found = 0;
    foreach ($lines as $lineNum => $lineContent) {
        if (preg_match($regex, $lineContent)) {
            $actualLine = $lineNum + 1;
            echo "Line {$actualLine}: " . trim($lineContent) . "\n";
            $found++;
            if ($found > 15) {
                echo "... and more\n";
                break;
            }
        }
    }
    if ($found === 0) echo "None found.\n";
    echo "\n";
}
