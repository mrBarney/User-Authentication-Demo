<?php 
	include('../server.php'); 

	if (!isAdmin()) {
		$_SESSION['msg'] = "You must be an administrator to view this page";
		header('location: ../index.php');
	}
	
	// when delete user button is clicked
	if (isset($_POST['delete_btn'])) {
		delete();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Demonstration</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<div class="header">
		<h2>Admin - create/delete user</h2>
	</div>
	<form method="post" action="create_delete_user.php">
	<a href="admin.php">(return to admin page)</a>
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
			<input type="text" name="username" >
		</div>

		<div class="input-group">
			<label>User type</label>
			<select name="user_type" id="user_type" >
				<option value=""></option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
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
			<button type="submit" class="btn" name="register_btn"> + Create user</button>
		</div>
	</form>

	<form method="post" action="create_delete_user.php">

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="delete_btn"> - Delete User</button>
		</div>
	</form>

</body>
</html>