<?php 
	include('server.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="header">
		<h2>Home Page</h2>
	</div>

	<div class="content">
		<!-- notification message -->
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
			<h3>Hi
				<?php echo $_SESSION['user']['username']; ?>!
				<small>
					<?php if(isAdmin()) : ?>
					<i style="font-size: 15px; font-weight: normal;">
						<a href="admin/admin.php">(<?php echo ucfirst($_SESSION['user']['user_type']);?>)</a>
					</i>
					<br>
					<? else : ?>
						<i style="font-size: 15px; font-weight: normal;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
						<? endif ?>
				</small>
			</h3>
			<div>
				<a href="success.php">
					<button type="submit" class="btn" name="heart_monitor_btn">Initiate Heart Monitor</button>
				</a>
			</div>
			<small>
				<p>
					<a href="index.php?logout='1'" style="color: red;">logout</a>
				</p>
			</small>
			<?php endif ?>
		</div>
	</div>
</body>

</html>