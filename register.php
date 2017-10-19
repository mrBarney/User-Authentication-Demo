<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Demonstration</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="header">
		<h2>Register</h2>
	</div>
	
	<form method="post" action="register.php">
		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Full Name</label>
			<input type="text" name="name">
		</div>
		<div class="input-group">
			<label>E-mail</label>
			<input type="text" name="email">
		</div>
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<label>Phone Number</label>
			<input type="text" name="phone">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn">Register</button>
		</div>
		<p>
			<a href="login.php">Sign in</a>
		</p>
	</form>

</body>
</html>