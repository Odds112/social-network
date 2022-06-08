<!DOCTYPE html>
<html>
	<head>
		<title>Account</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		
		<link href="http://localhost/soc/mainStyle.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<div class="container1 profile1">
			<div class="header1">
				<h2>Function</h2>
			</div>
			<form action="" method="GET">
				<input type="submit" class="submitBtn" value = "Sign out" name="logout">
                <input type="submit" class="submitBtn" value = "Main" name="main_page">
                <input type="submit" class="submitBtn" value = "Users" name="users">
			</form>
	</div>
		<div class="container">
	        <div class="header">
		        <h2>Account</h2>
	        </div>
	    <form class="form" id="form" action="" method="POST">
                <div class="form-control">
                    <label for="op1">Old password: </label>
	                <input type="password" name="old_password" id="op1">

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    
                </div>

                <div class="form-control">
                    <label for="op2">New password: </label>
                    <input type="password" name="new_password" id="op2">

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    
                </div>
                
                <div class="form-control">
                    <label for="op3">Confirm new password: </label>
	                <input type="password" name="new_password_confirm" id="op3">

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    
                </div>
                
                <div class="button">
                    <input type="submit" name="submit">
                </div>
                
            </form>
        </div>
	</body>
</html>

<?php
    if(isset($_REQUEST['logout'])) {
        header("Location: logout.php");
    }
    if(isset($_REQUEST['main_page'])) {
        header("Location: main_page.php?id=".$user['id']);
    }
    if(isset($_REQUEST['users'])) {
        header("Location: users.php");
    }
?>
<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $name = 'user';
    $link = mysqli_connect($host, $user, $pass, $name);

    session_start();
	$id = $_SESSION['id']; // id юзера из сессии
	$query = "SELECT * FROM users WHERE id='$id'";
	
	$result = mysqli_query($link, $query);
	$user = mysqli_fetch_assoc($result);
	if (!empty($_POST['submit'])) {
        if ($_POST['new_password'] == $_POST['new_password_confirm']) {
            $hash = $user['password']; // соленый пароль из БД
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            
            // Проверяем соответствие хеша из базы введенному старому паролю
            if (password_verify($oldPassword, $hash)) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                
                $query = "UPDATE users SET password='$newPasswordHash' WHERE id='$id'";
                mysqli_query($link, $query);
            } else {
                echo "The old password was entered incorrectly";
            }
        }
    }
?>