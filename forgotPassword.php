<?php
	include "db_connect.php";
	$link = db_connect::LinkConnection();
	
	if(isset($_REQUEST['reg'])) {
		$login = mb_strtolower($_POST['login']);
		
		$query = "SELECT * FROM users WHERE login='$login'";
		$result = mysqli_query($link, $query);
		$user = mysqli_fetch_assoc($result);
		if (!empty($user)) {
			session_start();
					$_SESSION['auth'] = $login;
					$_SESSION['id'] = $user['id'];
					$_SESSION['status'] = $user['status'];
					header("Location: forgotPassword2.php?id=".$user['id']);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Sign up</title>
<link href="http://localhost/soc/styleforSignUp.css" rel="stylesheet" type="text/css">	
</head>
<body>
<div class="signupFrm">
    <form action="" class="form" method="POST">
      <h2 class="title">Forgot password</h2>      
	
	  <div class="inputContainer">
        <input  class="input" name="login" placeholder="a" value="<?php if(isset($_POST['login'])) { echo htmlentities($_POST['login']); }?>">
        <label for="" class="label" >Login</label>
      </div>	 
    
		
      <input type="submit" class="submitBtn" value="Next" name="reg">
	   <div class="text-center">Already have an account? <a href="login1.php">Sign in</a></div>
    </form>
  </div>
</body>
</html>