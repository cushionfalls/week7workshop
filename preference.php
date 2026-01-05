<?php
session_start();

/* 1 & 2. Check login */
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

/* 3 & 4. Read theme cookie (default: light) */
$theme = $_COOKIE['theme'] ?? 'light';

/* Handle form submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? 'light';

    // 7. Set cookie for 30 days
    setcookie('theme', $theme, time() + (86400 * 30), "/");

    // Apply immediately
    header("Location: preference.php");
    exit;
}

/* 6. Logout handling */
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Preference</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="<?php echo $theme === 'dark' ? 'dark-mode' : ''; ?>">
    <div class="container">
        <h1>User Theme Preference</h1>

        <p>Current Theme: <strong><?php echo htmlspecialchars(ucfirst($theme)); ?> Mode</strong></p>

        <form method="post" class="preference-form">
            <div class="radio-group">
                <label>
                    <input type="radio" name="theme" value="light" <?php if ($theme === 'light') echo 'checked'; ?>>
                    Light Mode
                </label>

                <label>
                    <input type="radio" name="theme" value="dark" <?php if ($theme === 'dark') echo 'checked'; ?>>
                    Dark Mode
                </label>
            </div>

            <button type="submit">Save Preference</button>
        </form>

        <p class="text-center">
            <a href="dashboard.php">Back to Dashboard</a> |
            <a href="preference.php?logout=1">Logout</a>
        </p>
    </div>
</body>
</html>
