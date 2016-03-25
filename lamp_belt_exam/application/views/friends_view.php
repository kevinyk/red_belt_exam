<!DOCTYPE html>
<html>
<head>
<title>Friends</title>
<link rel="stylesheet" type="text/css" href="/assets/friends_style.css">
<head>
<h2>Hello, <?= $this->session->userdata['currentUser']['alias'] ?>!</h2>
<a href = '/Users/logout/' id = 'logout'>Logout</a>
<h3>Here is the list of your friends:</h3>
<?php echo $lonercheck; 
	if (!$lonercheck)
	{
?>
<table id = 'friends'>
	<tr>
		<td>Alias</td>
		<td>Action</td>
	</tr>
<?php
	foreach($friends as $friend)
	{
?>
	<tr>
		<td><?=$friend['alias'] ?></td>
		<td><a href = "user/<?=$friend['id'] ?>">View Profile</a> <a href = "Users/deleteFriendship/<?=$friend['id'] ?>">Remove as Friend</a></td>
	</tr>

<?php
	}
?>
</table>

<?php
}
?>
<h3>Other Users not on your friend's list:</h3>
<table id = 'notfriends'>
	<tr>
		<td>Alias</td>
		<td>Action</td>
	</tr>
<?php
	foreach($nonfriends as $nonfriend)
	{
?>
	<tr>
		<td><a href = "user/<?=$nonfriend['id'] ?>"><?= $nonfriend['alias'] ?></a></td>
		<td><a href = "Users/addFriend/<?=$nonfriend['id'] ?>">Add  as Friend</a></td>
	</tr>

<?php
	}
?>

</table>



</html>