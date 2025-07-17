<?php
require_once __DIR__ . '/db.php';

$queries = [
    "CREATE TABLE IF NOT EXISTS users (\n    id INT AUTO_INCREMENT PRIMARY KEY,\n    email VARCHAR(255) UNIQUE NOT NULL,\n    password VARCHAR(255) NOT NULL,\n    is_admin TINYINT(1) DEFAULT 0\n)",
    "CREATE TABLE IF NOT EXISTS domains (\n    id INT AUTO_INCREMENT PRIMARY KEY,\n    name VARCHAR(255) UNIQUE NOT NULL,\n    deletion_date DATE NOT NULL,\n    category VARCHAR(255) DEFAULT NULL\n)",
    "CREATE TABLE IF NOT EXISTS gemini_responses (\n    id INT AUTO_INCREMENT PRIMARY KEY,\n    domain_id INT NOT NULL,\n    category VARCHAR(255),\n    description TEXT,\n    raw_response TEXT,\n    created_at DATETIME,\n    FOREIGN KEY (domain_id) REFERENCES domains(id) ON DELETE CASCADE\n)",
    "CREATE TABLE IF NOT EXISTS favorites (\n    user_id INT NOT NULL,\n    domain_id INT NOT NULL,\n    remind TINYINT(1) DEFAULT 0,\n    PRIMARY KEY(user_id, domain_id),\n    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,\n    FOREIGN KEY (domain_id) REFERENCES domains(id) ON DELETE CASCADE\n)"
];

foreach ($queries as $sql) {
    $pdo->exec($sql);
}

echo "Tables created successfully.\n";

echo "\nCron jobs to configure:\n";
echo "* Daily fetch: php /path/to/cron/fetch_domains.php >> /var/log/fetch.log\n";
echo "* Gemini queries: php /path/to/cron/query_gemini.php >> /var/log/gemini.log\n";
echo "* Emails: php /path/to/cron/send_emails.php >> /var/log/emails.log\n";
?>
