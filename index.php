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
				<?php echo $_SESSION['user']['full_name']; ?>!
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

			<?php  if ($_SESSION['user']['resp_rate'] >= 12 && $_SESSION['user']['resp_rate'] <= 20) : ?>
			<h3 style="font-size: 15px; color: green">Respiration Rate: 
				<?php echo $_SESSION['user']['resp_rate']; ?>
				<i>(normal)</i>
			</h3>
			<? else : ?>
			<h3 style="font-size: 15px; color: red">Respiration Rate: 
				<?php echo $_SESSION['user']['resp_rate']; ?>
				<i>(abnormal)</i>
			</h3>
			<? endif ?>

			<?php  if ($_SESSION['user']['sys_blood'] <= 80 || $_SESSION['user']['dia_blood'] <= 60) : ?>
			<h3 style="font-size: 15px; color: rgb(180, 243, 64);">Blood Pressure:
				<?php echo $_SESSION['user']['sys_blood'];?>/<?php echo $_SESSION['user']['dia_blood'];?>
				<i>(hypotension)</i>
			</h3>
			<? elseif($_SESSION['user']['sys_blood'] >= 80 && $_SESSION['user']['sys_blood'] <= 120 && $_SESSION['user']['dia_blood'] >= 60 && $_SESSION['user']['dia_blood'] <= 80) : ?>
			<h3 style="font-size: 15px; color: green;">Blood Pressure:
				<?php echo $_SESSION['user']['sys_blood'];?>/<?php echo $_SESSION['user']['dia_blood'];?>
				<i>(normal)</i>
			</h3>
			<? elseif($_SESSION['user']['sys_blood'] >= 120 && $_SESSION['user']['sys_blood'] <= 139 || $_SESSION['user']['dia_blood'] >= 80 && $_SESSION['user']['dia_blood'] <= 89) : ?>
			<h3 style="font-size: 15px; color: yellow;">Blood Pressure:
				<?php echo $_SESSION['user']['sys_blood'];?>/<?php echo $_SESSION['user']['dia_blood'];?>
				<i>(prehypertension)</i>
			</h3>
			<? elseif($_SESSION['user']['sys_blood'] >= 140 && $_SESSION['user']['sys_blood'] <= 159 || $_SESSION['user']['dia_blood'] >= 90 && $_SESSION['user']['dia_blood'] <= 99) : ?>
			<h3 style="font-size: 15px; color: orange;">Blood Pressure:
				<?php echo $_SESSION['user']['sys_blood'];?>/<?php echo $_SESSION['user']['dia_blood'];?>
				<i>(hypertension stage 1)</i>
			</h3>
			<? elseif($_SESSION['user']['sys_blood'] >= 160 && $_SESSION['user']['sys_blood'] <= 179 || $_SESSION['user']['dia_blood'] >= 100 && $_SESSION['user']['dia_blood'] <= 109) : ?>
			<h3 style="font-size: 15px; color: red;">Blood Pressure:
				<?php echo $_SESSION['user']['sys_blood'];?>/<?php echo $_SESSION['user']['dia_blood'];?>
				<i>(hypertension stage 2)</i>
			</h3>
			<? elseif($_SESSION['user']['sys_blood'] >= 180 || $_SESSION['user']['dia_blood'] >= 110) : ?>
			<h3 class="flash">Blood Pressure:
				<?php echo $_SESSION['user']['sys_blood'];?>/<?php echo $_SESSION['user']['dia_blood'];?>
				<i>(hypertension) - seek emergency care</i>
			</h3>
			<? endif ?>

			<?php  if ($_SESSION['user']['pulse_rate'] >= 20 && $_SESSION['user']['pulse_rate'] <= 100) : ?>
			<h3 style="font-size: 15px; color: green;">Pulse Rate: 
				<?php echo $_SESSION['user']['pulse_rate']; ?>
				<i>(normal)</i>
			</h3>
			<? elseif($_SESSION['user']['pulse_rate'] >= 101) : ?>
			<h3 style="font-size: 15px; color: red;">Pulse Rate: 
				<?php echo $_SESSION['user']['pulse_rate']; ?>
				<i>(high)</i>
			</h3>
			<? endif ?>

			<?php  if ($_SESSION['user']['body_temp'] >= 97.7 && $_SESSION['user']['body_temp'] <= 99.5) : ?>
			<h3 style="font-size: 15px; color: green;">Body Temperature: 
				<?php echo $_SESSION['user']['body_temp']; ?>
				<i>(normal)</i>
			</h3>
			<? elseif($_SESSION['user']['body_temp'] >= 99.6 && $_SESSION['user']['body_temp'] <= 100.3) : ?>
			<h3 style="font-size 15px; color: rgb(206, 206, 53);">Body Temperature:
				<?php echo $_SESSION['user']['body_temp']; ?>
				(check for fever)
			</h3>
			<? elseif($_SESSION['user']['body_temp'] >= 100.4 && $_SESSION['user']['body_temp'] <= 103.9) : ?>
			<h3 style="font-size 15px; color: red;">Body Temperature:
				<?php echo $_SESSION['user']['body_temp']; ?>
				<i>(fever)</i>
			</h3>
			<? elseif($_SESSION['user']['body_temp'] >= 104) : ?>
			<h3 class="flash">Body Temperature:
				<?php echo $_SESSION['user']['body_temp']; ?>
				<i>(hypothermia)</i>
			</h3>
			<? endif ?>

			<br>
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