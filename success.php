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
	<title>SUCCESS</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="3;url=index.php" />
</head>
<div class="content">
		<!-- notification message -->
			<div class="error success" >
				<h3>
                    File successfully executed - Redirecting...
				</h3>
			</div>
    </div>
    </body>
</html>