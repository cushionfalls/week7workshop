<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require 'db.php';

// Fetch user name from database if not in session
if (!isset($_SESSION['student_name']) && isset($_SESSION['student_id'])) {
    $stmt = $pdo->prepare("SELECT full_name FROM students WHERE student_id = ?");
    $stmt->execute([$_SESSION['student_id']]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['student_name'] = $user['full_name'];
    }
}

$theme = $_COOKIE['theme'] ?? 'light';
$userName = $_SESSION['student_name'] ?? 'User';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo $theme === 'dark' ? 'dark-mode' : ''; ?>">
    <div class="container">
        <div class="welcome-message">
            <h1>Welcome to Dashboard</h1>
            <p>
                Hello, <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
            </p>
        </div>

        <nav>
            <a href="preference.php">Preferences</a> |
            <a href="preference.php?logout=1">Logout</a>
        </nav>
    </div>
</body>
</html>
