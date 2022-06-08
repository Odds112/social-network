<?php
	session_start();
	$_SESSION['auth'] = null;

    if(isset($_REQUEST['login'])) {
        header("Location: login1.php");
    }
    if(isset($_REQUEST['register'])) {
        header("Location: register1.php");
    }
?>


<div class="container">
	<div class="header">
		<h2>Log out</h2>
	</div>
	<form action="" method="GET">
		<div class="form-control">
            <input type="submit" value = "Sign in" name="login">
            <input type="submit" value = "Sign up" name="register">
		</div>
	</form>
</div>