<?php 
	include('../server.php');

	if (!isAdmin()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../login.php");
	}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
	<link rel="stylesheet" href="../css/style.css">
</head>

<body>
	<div class="header">
		<h2>Admin Page</h2>
	</div>
	<div class="content">
		<!-- notification -->
		<?php if (isset($_SESSION['success'])) : ?>
		<div class="error success">
			<h3>
				<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
			</h3>
		</div>
		<?php endif ?>

		<!-- logged in user information -->
		<div class="info">
			<?php  if (isset($_SESSION['user'])) : ?>
			<p>
				<small>
					<a href="../index.php">(return to index)</a>
				</small>
			</p>
			<div>
				<a href="patient_data.php">
					<button class="btn" name="patient_vitals_btn">Input Patient Vitals</button>
				</a>
				<a href="create_delete_user.php">
					<button class="btn" name="add_delete_user">+/- user</button>
				</a>
			</div>
			<p>
				<a href="admin.php?logout='1'" style="color: red;">logout</a>
			</p>
			</small>
			<?php endif ?>
		</div>
	</div>
</body>

</html>