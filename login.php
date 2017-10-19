<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>User Authentication Demo</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Login</h2>
	</div>
	<form method="post" action="login.php">
		<!-- notification -->
		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_btn">Login</button>
		</div>
		<p>
			<a href="register.php">Sign up</a>
		</p>
	</form>
</body>
</html>