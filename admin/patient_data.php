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

		<div class="input-group">
			<label>Choose user</label>
			<select name="username" id="user_type">
				<?php
				$query = "SELECT * FROM users";
				$result = mysqli_query($db,$query);
				while ($rows = mysqli_fetch_assoc($result)) { ?>
					<option value="<?php echo $rows['username'];?>"><?php echo $rows['username'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="input-group">
			<label>Respiration Rate (breaths per minute)</label>
			<input type="text" name="resp_rate">
		</div>
		<div class="input-group">
			<label>Systolic Blood Pressure (mm Hg)</label>
			<input type="text" name="sys_blood">
        </div>
        <div class="input-group">
			<label>Diastolic Blood Pressure (mm Hg)</label>
			<input type="text" name="dia_blood">
		</div>
		<div class="input-group">
			<label>Pulse Rate (beats per minute)</label>
			<input type="text" name="pulse_rate">
        </div>
        <div class="input-group">
			<label>Body Temperature (fahrenheit)</label>
			<input type="text" name="body_temp">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="vital_btn">Submit</button>
		</div>
    </form>
    
</body>

</html>