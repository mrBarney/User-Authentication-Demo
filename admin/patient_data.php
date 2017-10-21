<?php 
	include('../server.php');

	if (!isAdmin()) {
		$_SESSION['msg'] = "You must be an administrator to view this page";
		header('location: ../index.php');
	}

	// when vital button is clicked
	if (isset($_POST['vital_btn'])) {
		submitVitals();
	}

	if(isset($_POST['chooseUser'])) {
		$username = e($_POST['chooseUser']);
		$query = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($db, $query);
		while($selected_user = mysqli_fetch_assoc($results)) {
			$resp_rate = $selected_user['resp_rate'];
			$sys_blood = $selected_user['sys_blood'];
			$dia_blood = $selected_user['dia_blood'];
			$pulse_rate = $selected_user['pulse_rate'];
			$body_temp = $selected_user['body_temp'];
		}
	}
	$query = "SELECT username FROM users WHERE username!='$username'";
	$result = mysqli_query($db,$query);
?>


<!DOCTYPE html>
<html>

<head>
	<title>Patient Data</title>
	<link rel="stylesheet" href="../css/style.css">
</head>

<body>
	<div class="header">
		<h2>Input Patient Data</h2>
	</div>
	<form method="post" action="patient_data.php">
		<a href="admin.php">(return to admin page)</a>
		<?php echo display_error(); ?>

		<div class="patient">
			<label>Choose user</label>
			<select name="chooseUser" id="user_type" onchange="this.form.submit()">
				<option value="<?php echo $username;?>">
					<?php echo $username;?>
				</option>
				<?php
				while ($rows = mysqli_fetch_assoc($result)) { ?>
					<option value="<?php echo $rows['username'];?>">
						<?php echo $rows['username'];?>
					</option>
					<?php } ?>
			</select>
		</div>
	</form>

	<form method="post" action="patient_data.php">
		<div class="patient">
			<label>Respiration Rate (breaths per minute)</label>
			<br>
			<input type="text" name="resp_rate" <?php if(isset($resp_rate)) : ?> value="<?php echo $resp_rate;?>" <?php else : ?> value=""<?php endif?>>
		</div>
		<br>
		<div class="patient">
			<label>Blood Pressure</label>
			<br>
			<input type="text" name="sys_blood" <?php if(isset($sys_blood)) : ?> value="<?php echo $sys_blood;?>"<?php else : ?> value=""<?php endif?>>
			<label> - Systolic</label>
			<p><input type="text" name="dia_blood" <?php if(isset($dia_blood)) : ?> value="<?php echo $dia_blood;?>"<?php else : ?> value=""<?php endif?>>
			<label> - Diastolic </label></p>
		</div>
		<br>
		<div class="patient">
			<label>Pulse Rate (beats per minute)</label>
			<br>
			<input type="text" name="pulse_rate" <?php if(isset($pulse_rate)) : ?> value="<?php echo $pulse_rate;?>"<?php else : ?> value=""<?php endif?>>
		</div>
		<div class="patient">
			<label>Body Temperature (fahrenheit)</label>
			<br>
			<input type="text" name="body_temp" <?php if(isset($body_temp)) : ?> value="<?php echo $body_temp;?>"<?php else : ?> value=""<?php endif?>>
		</div>
		<input type="text" name="username" style="visibility: hidden;" value="<?php echo $username; ?>">
		<br>
		<div class="patient">
			<button type="submit" class="btn" name="vital_btn">Submit</button>
		</div>
	</form>

</body>
</html>