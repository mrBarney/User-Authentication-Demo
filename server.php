<?php 
session_start();

// connect to database
$db = mysqli_connect('192.168.64.2', 'root', '', 'registration');

$username = "";
$errors   = array(); 

// when logout button is clicked
if (isset($_GET['logout'])) {
	logout();
}

// REGISTER USER
function register()
{
	global $db, $errors, $username;

	// e() used to escape values
	$username    =  e($_POST['username']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);
	$email   	 =  e($_POST['email']);
	$name   	 =  e($_POST['name']);
	$phone  	 =  e($_POST['phone']);

	//eliminate every char except 0-9
	$correctedPhone = preg_replace("/[^0-9]/", '', $phone);
	//eliminate leading 1 if its there
	if (strlen($correctedPhone) == 11) {
		$correctedPhone = preg_replace("/^1/", '',$justNums);
	}

	// form validation
	if (empty($username) || empty($password_1) || empty($email) || empty($name) || empty($phone)) { 
		array_push($errors, "The entire form must be completed"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	if(strlen($username) > 24 || strlen($username) < 6) {
		array_push($errors, "Username must be between 6 and 24 characters");
	}
	if(strlen($password_1) > 20 || strlen($password_1) < 6) {
		array_push($errors, "Password must be between 6 and 20 characters");
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Invalid e-mail format");
	}
	if (strlen($correctedPhone) != 10) {
		array_push($errors, "Incorrect phone number");
	}

	// check if username/email already exists
	$result = mysqli_query($db, "SELECT username, email FROM users WHERE username='$username' OR email='$email'");
	if(mysqli_num_rows($results) >= 1) {
		array_push($errors, "Username or email already exists");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1); // encrypt the password before saving in the database

		if (isset($_POST['user_type'])) { // if user_type is defined, we know an admin is creating the account
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, full_name, email, phone_number, user_type, password) VALUES('$username', '$name', '$email', '$correctedPhone', '$user_type', '$password')"; // save creds in database
			mysqli_query($db, $query);
			$_SESSION['success']  = "User successfully created";
			header('location: ../index.php');
		}
		else { // if user_type isn't defined, it's normal registration
			$query = "INSERT INTO users (username, full_name, email, phone_number, user_type, password) VALUES('$username', '$name', '$email', '$correctedPhone', 'user', '$password')";
			mysqli_query($db, $query);
			$logged_in_user_id = mysqli_insert_id($db); // get id of the created user
			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "Welcome!";
			header('location: index.php');				
		}
	}
}

// LOGIN USER
function login()
{
	global $db, $username, $errors;

	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// login form validation
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// if login is successful, reset failed_login_attempts
			$query = "UPDATE users SET failed_login_attempts = 0 WHERE username='$username'"; 
			mysqli_query($db, $query);
			
			$_SESSION['user'] = mysqli_fetch_assoc($results); // get session info
			
			header('location: index.php');
		}
		else {
			// if login is unsuccessful, increment failed_login_attempts
			$query = "UPDATE users SET failed_login_attempts = failed_login_attempts + 1 WHERE username='$username'"; 
			mysqli_query($db, $query);
			
			if(getFailedLoginAttempts($username) == 2) {
				array_push($errors, "You have one attempt remaining before an email is sent to the associated account.");
			}
			else if(getFailedLoginAttempts($username) >= 3) {
				array_push($errors, "An email has been sent to the associated account.");			
			}
			else {
				array_push($errors, "Wrong username/password combination");
			}
		}
		// log successful/unsuccessful logins
		$line = "$_SERVER[REMOTE_ADDR]";
		$query = "UPDATE users SET ip_of_last_login = '$line' WHERE username='$username'";
		mysqli_query($db, $query);
	}
}

function delete()
{
	global $db, $username, $errors;
	
		$username = e($_POST['username']);
		$password = e($_POST['password']);
	
		// delete user form validation
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}
	
		// attempt delete if no errors
		if (count($errors) == 0) {
			$password = md5($password);
	
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) { // user found
				// delete user
				$query = "DELETE FROM users WHERE username='$username' AND password='$password' LIMIT 1";
				$results = mysqli_query($db, $query);
				$_SESSION['success']  = "User successfully deleted";
				
				// if deleted user is currently logged in, log them out
				if(isset($_SESSION['user']) && $_SESSION['user']['username'] == $username){
					logout();
				}
				header('location: admin.php');
			}
			else { // user not found
				array_push($errors, "Incorrect username or password");
			}
		}
}

function submitVitals()
{
	global $db, $errors;

	$resp_rate = e($_POST['resp_rate']);
	$sys_blood = e($_POST['sys_blood']);
	$dia_blood = e($_POST['dia_blood']);
	$pulse_rate = e($_POST['pulse_rate']);
	$body_temp = e($_POST['body_temp']);
	$username = e($_POST['username']);

	// form validation
	if (empty($username) || empty($resp_rate) || empty($sys_blood) || empty($dia_blood) || empty($pulse_rate) || empty($body_temp)) {
		array_push($errors, "The entire form must be filled out");
	}
	if (!is_numeric ($resp_rate) || !is_numeric ($sys_blood) || !is_numeric ($dia_blood) || !is_numeric ($pulse_rate) || !is_numeric ($body_temp)) {
		array_push($errors, "Only numbers are accepted");
	}

	if (count($errors) == 0) {
		$query = "UPDATE users SET resp_rate='$resp_rate', sys_blood='$sys_blood', dia_blood='$dia_blood', pulse_rate='$pulse_rate', body_temp='$body_temp' WHERE username='$username'";
		mysqli_query($db, $query);
		
		// update session with new data
		$query = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($db, $query);

		if($_SESSION['user']['username'] == $username) { // if logged in, update session
			$_SESSION['user'] = mysqli_fetch_assoc($results); 
		}

		$_SESSION['success']  = "Vitals Successfully Updated";
		header('location: ../index.php');
	}
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}
	else {
		return false;
	}
}

// return user info from their id
function getUserById($id)
{
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string - try to avoid SQL injection
function e($val)
{
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error()
{
	global $errors;

	if (count($errors) > 0){
		echo '<div style="width: 90%; margin: 10px 10px 0px; padding: 10px; color: #da2b28; background: #f3d5d5; border-radius: 5px; text-align: center;">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}
	else {
		return false;
	}
}

function getFailedLoginAttempts($username)
{
	global $db;
	$query = "SELECT failed_login_attempts FROM users WHERE username='$username'";
	$result = mysqli_query($db, $query);
	$r = mysqli_fetch_assoc($result);
	$failed_login_attempts = $r['failed_login_attempts'];
	return $failed_login_attempts;
}

function logout()
{
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}
