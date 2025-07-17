<?php
require_once __DIR__ . '/../functions.php';

// Summary emails after gemini processing
$stmt = $pdo->query("SELECT email, GROUP_CONCAT(d.name SEPARATOR ', ') AS domains FROM users u JOIN favorites f ON u.id=f.user_id JOIN domains d ON f.domain_id=d.id GROUP BY u.id");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $u) {
    $body = "Processed domains: " . $u['domains'];
    send_email($u['email'], 'Domain Summary', $body);
}

// Reminder emails one day before domain availability if marked favorite
$stmt = $pdo->prepare("SELECT u.email, d.name FROM favorites f JOIN users u ON f.user_id=u.id JOIN domains d ON f.domain_id=d.id WHERE f.remind=1 AND d.deletion_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)");
$stmt->execute();
$reminders = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($reminders as $r) {
    send_email($r['email'], 'Domain Reminder', $r['name'] . ' becomes available tomorrow');
}
?>
