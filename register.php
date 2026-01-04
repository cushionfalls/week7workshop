<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
</head>
<body>
	<form action="register.php" method="post">
			<ul>
				<label>Student id</label>
				<input type="text" id="student_id" required>
			</ul>
			<ul>
				<label>Name</label>
				<input type="text" id="name" required>
			</ul>
			<ul>
				<label>Password</label>
				<input type="password" id="password" required>
			</ul>
			<ul>
				<button onclick="sumbit">Sumbit</button>
			</ul>
	</form>
</body>
</html>
<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
	$student_id = $_POST['student_id'] ?? '';
	$name = $_POST['name'] ?? '';
	$password = $_POST['password'] ?? '';
	$student_id = trim($student_id);
	if(empty($student_id)||empty($name)||empty($password)){
		die("All fields are required");
	}
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	echo "Saved";
}
else{
	echo "Please sumbit the form porperly";
}
?>
