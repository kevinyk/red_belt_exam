<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/assets/profile_style.css">
<title><?= $alias ?></title>
<a href = '/friends' id = 'home'>Home</a> <a href = '/Users/logout/' id = 'logout'>Logout</a>
<h1><?= $alias ?>'s Profile</h1>
<table>
	<tr>
		<td>Name:</td>
		<td><?= $name ?></td>
	</tr>
	<tr>
		<td>Email Address:</td>
		<td><?= $email ?></td>
	</tr>
</table>

<head>