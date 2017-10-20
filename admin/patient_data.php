<?php 
	include('../server.php');

	if (!isAdmin()) {
		$_SESSION['msg'] = "You must be an administrator to view this page";
		header('location: ../index.php');
	}
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
			<select name="username" id="user_type">
				<option value=""></option>
				<?php
				$query = "SELECT * FROM users";
				$result = mysqli_query($db,$query);
				while ($rows = mysqli_fetch_assoc($result)) { ?>
					<option value="<?php echo $rows['username'];?>"><?php echo $rows['username'];?></option>
				<?php } ?>
			</select>
		</div>
		<br>
		<div class="patient">
			<label>Respiration Rate (breaths per minute)</label>
			<br>
			<input type="text" name="resp_rate" value="<?php echo $_SESSION['user']['resp_rate']?>">
		</div>
		<br>
		<div class="patient">
			<label>Blood Pressure</label>
			<br>
			<label>Systolic </label>
			<input type="text" name="sys_blood" value="<?php echo $_SESSION['user']['sys_blood']?>">
			<label>Diastolic </label>
			<input type="text" name="dia_blood" value="<?php echo $_SESSION['user']['dia_blood']?>">
		</div>
		<br>
		<div class="patient">
			<label>Pulse Rate (beats per minute)</label>
			<br>
			<input type="text" name="pulse_rate" value="<?php echo $_SESSION['user']['pulse_rate']?>">
        </div>
        <div class="patient">
			<label>Body Temperature (fahrenheit)</label>
			<br>
			<input type="text" name="body_temp" value="<?php echo $_SESSION['user']['body_temp']?>">
		</div>
		<br>
		<div class="patient">
			<button type="submit" class="btn" name="vital_btn">Submit</button>
		</div>
    </form>
    
</body>

</html>