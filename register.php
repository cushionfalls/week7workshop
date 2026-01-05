<?php
$theme = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
	<link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo $theme === 'dark' ? 'dark-mode' : ''; ?>">
	<div class="container">
		<h1>Register</h1>
		<form action="register.php" method="post">
			<ul>
				<label>Student id</label>
				<input type="text" name="student_id" required>
			</ul>
			<ul>
				<label>Name</label>
				<input type="text" name="name" required>
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
			Already have an account? <a href="login.php">Login here</a>
		</p>
	</div>
</body>
</html>
<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = trim($_POST['student_id'] ?? '');
    $name       = trim($_POST['name'] ?? '');
    $password   = $_POST['password'] ?? '';

    if (empty($student_id) || empty($name) || empty($password)) {
        die("All fields are required");
    }

    $check = $pdo->prepare("SELECT id FROM students WHERE student_id = ?");
    $check->execute([$student_id]);

    if ($check->rowCount() > 0) {
        die("Student ID already exists");
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO students (student_id, full_name, password_hash)
                VALUES (:student_id, :full_name, :password_hash)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':student_id'   => $student_id,
            ':full_name'    => $name,
            ':password_hash'=> $password_hash
        ]);
        header("Location: login.php?success=1");
        exit;

    } catch (PDOException $e) {
        die("Insert failed: " . $e->getMessage());
    }
}
?>
