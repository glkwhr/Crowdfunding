<?php switch ($mode): ?>
<?php case 'successful': ?>
	<a class="big" href="<?php echo APP_URL ?>">Registration succeeded! Click to return to index.</a>
<?php break; ?>
<?php case 'failed': ?>
	<a class="big" href="<?php echo APP_URL ?>/user/register">Registration Failed! Click to return to retry.</a>
<?php break; ?>
<?php case 'register': ?>
	<!-- Show registration form -->
	<form action="<?php echo APP_URL ?>/user/register" method="post">
		<label>Username</label>
		<br/>
	    <input type="text" value="Username" onclick="this.value=''" name="usrname">
	    <br/><br/>
	    <label>Real Name</label>
		<br/>
	    <input type="text" value="Real Name" onclick="this.value=''" name="realname">
	    <br/><br/>
	    <label>Password</label>
	    <br/>
	    <input type="password" name="pwd">
	    <br/><br/>
	    <input type="submit" value="Register">
	</form>
<?php endswitch ?>
