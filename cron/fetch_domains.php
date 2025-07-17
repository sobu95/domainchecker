<?php
require_once __DIR__ . '/../functions.php';

$contents = fetch_domains_file();
if ($contents === false) {
    echo "Failed to download file\n";
    exit(1);
}
$lines = explode("\n", trim($contents));
foreach ($lines as $line) {
    if (!$line) continue;
    [$domain, $date] = array_pad(explode(';', $line), 2, date('Y-m-d'));
    save_domain(trim($domain), $date);
}
?>
