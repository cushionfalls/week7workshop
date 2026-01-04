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
				<label>Password</label>
				<input type="password" id="password" required>
			</ul>
			<ul>
				<button onclick="sumbit">Sumbit</button>
			</ul>
	</form>
</body>
</html>