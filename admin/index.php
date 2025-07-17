<?php
require_once __DIR__ . '/../functions.php';
require_login();
if (!is_admin()) {
    die('Access denied');
}
$config = require __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config['gemini_api_key'] = $_POST['api_key'] ?? $config['gemini_api_key'];
    $config['gemini_model'] = $_POST['model'] ?? $config['gemini_model'];
    file_put_contents(__DIR__ . '/../config.php', "<?php\nreturn " . var_export($config, true) . ";\n");
    echo '<div class="alert alert-success">Config saved</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
<h1>Admin Panel</h1>
<form method="post">
    <div class="mb-3">
        <label>Gemini API Key</label>
        <input type="text" name="api_key" class="form-control" value="<?php echo htmlspecialchars($config['gemini_api_key']); ?>">
    </div>
    <div class="mb-3">
        <label>Gemini Model</label>
        <input type="text" name="model" class="form-control" value="<?php echo htmlspecialchars($config['gemini_model']); ?>">
    </div>
    <button class="btn btn-primary">Save</button>
</form>
</body>
</html>
