<?php
	include "db_connect.php";
?>
<?php
	$link = db_connect::LinkConnection();
	
	if (!empty($_GET['password']) and !empty($_GET['login'])) {

		$login = mb_strtolower($_GET['login']);
		
		$query = "SELECT * FROM users WHERE login='$login'";
		$result = mysqli_query($link, $query);
		$user = mysqli_fetch_assoc($result);
		if (!empty($user)) {
			$hash = $user['password']; // соленый пароль из БД
			// Сравниваем соленые хеши
			if (password_verify($_GET['password'], $hash)) {
				// все ок, авторизуем...
				// Пользователь прошел авторизацию, запишем в сессию пометку об этом:
				if($user['banned'] != 1	) {
					session_start();
					$_SESSION['auth'] = $login;
					$_SESSION['id'] = $user['id'];
					$_SESSION['status'] = $user['status']; // записываем статус

					header("Location: main_page.php?id=".$user['id']);
				} else echo "Your account is banned!";
			} else {
				echo("The password is not correct");
			}
		} 
		else echo "The login is not correct";
	}	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Login</title>
	<link href="http://localhost/soc/style1.css" rel="stylesheet" type="text/css">	
</head>
<body>	
	
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Sign In </h2>    

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="front.jpg" id="icon" alt="User Icon" />
    </div>

    <!-- Login Form -->
    <form action="" method="GET">
      <input type="text" id="login" class="fadeIn second" name="login" placeholder="login">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
      <input type="submit" class="fadeIn fourth" value="Log In">
	  <div class="text-center">Don't have an account? <a href="register1.php">Register Here</a></div>
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="forgotPassword.php">Forgot Password?</a>
    </div>

  </div>

</body>
</html>