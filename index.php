<?php
require_once __DIR__ . '/functions.php';
require_login();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Domain Checker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
<p><a href="admin/">Admin Panel</a> | <a href="logout.php">Logout</a></p>
<!-- Domain list placeholder -->
</body>
</html>
