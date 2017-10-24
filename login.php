<?php 
	include('server.php');

	// when login button is clicked
	if (isset($_POST['login_btn'])) {
		login();
	}
?>

<!DOCTYPE html>
<html>

<head>
	<title>User Authentication Demo</title>
	<style type="text/css">
	html { height: 100%; }
	body { font-size: 18px; font-family: tahoma; color: #fff; height: 100%; margin:0; padding:0; background-size: cover; background-color: #000000; background-repeat: no-repeat; background-position: center center; background-image: url('img/Lighthouse.jpg') }
	</style>

</head>

<body>
<div style="width: 450px; margin: auto 200px; text-align: left; padding: 20px; color: rgb(165, 165, 165); text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
		<p style="font-size: 35px">CARE System<br>Login Authentication</p>
		
	<form method="post" action="login.php">
		<?php echo display_error(); ?>

			<label>Class</label>
			<br>
			<input type="text" name="class" style="width: 290px; margin: 10px 10px 0px; padding: 5px;  border: 1px solid rgb(255, 255, 255); font-size: 18px;">	
		<br>
			<label>AuthCode</label>
			<br>
			<input type="text" name="auth_code" style="width: 290px; margin: 10px 10px 0px; padding: 5px; border: 1px solid rgb(255, 255, 255); font-size: 18px;">
		<div style="padding: 20px"></div>
			<label>UserID</label>
			<br>
			<input type="text" name="username" style="width: 290px; margin: 10px 10px 0px; padding: 5px; border: 1px solid rgb(255, 255, 255); font-size: 18px; ">
		<br>
			<label>Password</label>
			<br>
			<input type="password" name="password" style="width: 290px; margin: 10px 10px 0px; padding: 5px; border: 1px solid rgb(255, 255, 255); font-size: 18px;">
		<br>
		<div style="padding: 10px"></div>
			<button type="submit" name="login_btn" style="margin: 10px 10px 0px; padding: 10px; font-size: 15px; color: rgb(255, 255, 255); background: rgb(66, 134, 165);">Login</button>
			<br>
			<a style="margin: 10px 10px 0px;" href="register.php">Sign up</a>
			</div>
	</form>
</body>

</html>