<?php
require_once __DIR__ . '/db.php';
session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}

function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function check_password($password, $hash) {
    return password_verify($password, $hash);
}

function fetch_domains_file() {
    $url = 'https://www.dns.pl/deleted_domains.txt';
    return file_get_contents($url);
}

function save_domain($name, $date, $category = null) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO domains (name, deletion_date, category) VALUES (?, ?, ?)');
    $stmt->execute([$name, $date, $category]);
    return $pdo->lastInsertId();
}

function save_gemini_response($domain_id, $category, $description, $json) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO gemini_responses (domain_id, category, description, raw_response, created_at) VALUES (?, ?, ?, ?, NOW())');
    $stmt->execute([$domain_id, $category, $description, $json]);
}

function send_email($to, $subject, $body) {
    // Simplified mail sending
    mail($to, $subject, $body);
}
