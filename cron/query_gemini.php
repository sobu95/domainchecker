<?php
require_once __DIR__ . '/../functions.php';
$config = require __DIR__ . '/../config.php';

$stmt = $pdo->query("SELECT id, name FROM domains WHERE id NOT IN (SELECT domain_id FROM gemini_responses)");
$domains = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($domains as $dom) {
    $prompt = "Describe domain " . $dom['name'];
    $response = query_gemini($prompt, $config['gemini_api_key'], $config['gemini_model']);
    $data = json_decode($response, true);
    $category = $data['category'] ?? 'general';
    $description = $data['description'] ?? '';
    save_gemini_response($dom['id'], $category, $description, $response);
}

function query_gemini($prompt, $api_key, $model) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$api_key";
    $payload = json_encode(['contents' => [['parts' => [['text' => $prompt]]]]]);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    if ($result === false) {
        $result = json_encode(['error' => curl_error($ch)]);
    }
    curl_close($ch);
    return $result;
}
?>
