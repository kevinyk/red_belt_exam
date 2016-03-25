<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/assets/login_style.css">
<title>Login/Registration</title>
<head>
	
	<form action = '/Users/process_register' method = 'POST'>
	<h2>Register</h2>
	<?php echo $this->session->userData('regError'); ?>
		Name: <input type = 'text' name = 'name'>
		Alias: <input type = 'text' name = 'alias'>
		Email Address: <input type = 'text' name = 'email'>
		Password: <input type = 'password' name = 'password'>
		Confirm Password: <input type = 'password' name = 'passwordconf'>
		Date of Birth: <input type = 'date' name ='dob'>
		<input type = 'submit' value = 'Register'>
	</form>
	
	<form action = '/Users/process_login' method = 'POST'>
	<h2>Login</h2>
	<?php echo $this->session->userData('loginError'); ?>
		Email Address: <input type = 'text' name = 'email'>
		Password: <input type = 'password' name = 'password'>
		<input type = 'submit' value = 'Sign In'>
	</form>


</html>