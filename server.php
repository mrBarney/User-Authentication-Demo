<?php 
session_start();

// connect to database
$db = mysqli_connect('192.168.64.2', 'root', '', 'registration');

$username = "";
$errors   = array(); 

// when register button is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// when heart monitor button is clicked
if (isset($_POST['heart_monitor_btn'])){
	$_SESSION['success']  = "File successfully executed";
	header('location: success.php');
}

// when login button is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// when delete user button is clicked
if (isset($_POST['delete_btn'])) {
	delete();
}

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

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
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

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1); // encrypt the password before saving in the database

		if (isset($_POST['user_type'])) { // if user_type is defined, we know an admin is creating the account
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, user_type, password) VALUES('$username', '$user_type', '$password')"; // save creds in database
			mysqli_query($db, $query);
			$_SESSION['success']  = "User successfully created";
			header('location: ../index.php');
		}
		else { // if user_type isn't defined, it's normal registration
			$query = "INSERT INTO users (username, user_type, password) VALUES('$username', 'user', '$password')";
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
			
			$logged_in_user = mysqli_fetch_assoc($results); // get user info
			
			$_SESSION['user'] = $logged_in_user; // save user
			$_SESSION['success']  = "Welcome!";
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
		echo '<div class="error">';
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
