<?php include('server.php') ?>
<!DOCTYPE html>
<html>

<head>
	<title>User Authentication Demo</title>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="header">
		<p style="font-size: 35px">CARE System</p>
		Login Authentication
	</div>
	<form method="post" action="login.php">
		<!-- notification -->
		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username">
		</div>
		<br>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<br>
		<div class="input-group">
			<button type="submit" class="btn" name="login_btn">Login</button>
		</div>
		<div align="left">
			<a href="register.php">Sign up</a>
		</div>
	</form>
</body>

</html>