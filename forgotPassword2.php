<!DOCTYPE html>
<html>
	<head>
		<title>Account</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		
		<link href="http://localhost/soc/styleforSignUp.css" rel="stylesheet" type="text/css">	
	</head>
	<body>	
		<div class="signupFrm">
			<form action="" class="form" method="POST">              
				<h1 class="title">Forgot password</h1> 
				
                 <div class="inputContainer">
                    <label for="op2">New password: </label>
                    <input type="password" name="new_password" id="op2">

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    
                </div>
                
                 <div class="inputContainer">
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
            $newPassword = $_POST['new_password'];
            
            
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                
                $query = "UPDATE users SET password='$newPasswordHash' WHERE id='$id'";
                mysqli_query($link, $query);           
        }
		header("Location: login1.php");
    }
?>