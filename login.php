<?php
session_start();
require 'db.php';

// Redirect if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$theme = $_COOKIE['theme'] ?? 'light';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = trim($_POST['student_id'] ?? '');
    $password   = $_POST['password'] ?? '';

    if (empty($student_id) || empty($password)) {
        die("All fields are required");
    }
    $stmt = $pdo->prepare(
        "SELECT password_hash, full_name FROM students WHERE student_id = ?"
    );
    $stmt->execute([$student_id]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Student ID not found");
    }

    $storedHash = $user['password_hash'];

    if (!password_verify($password, $storedHash)) {
        die("Invalid password");
    }

    $_SESSION['logged_in'] = true;
    $_SESSION['student_id'] = $student_id;
    $_SESSION['student_name'] = $user['full_name'];

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo $theme === 'dark' ? 'dark-mode' : ''; ?>">
	<div class="container">
		<h1>Login</h1>
		<?php if (isset($_GET['success'])): ?>
			<div class="message success">Registration successful! Please login.</div>
		<?php endif; ?>
		<form action="login.php" method="post">
			<ul>
				<label>Student id</label>
				<input type="text" name="student_id" required>
			</ul>
			<ul>
				<label>Password</label>
				<input type="password" name="password" required>
			</ul>
			<ul>
				<button type="submit">Submit</button>
			</ul>
		</form>
		<p class="text-center">
			Don't have an account? <a href="register.php">Register here</a>
		</p>
	</div>
</body>
</html>
