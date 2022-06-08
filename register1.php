<!DOCTYPE html>
<html lang="en">
<head>
<title>Sign up</title>
<link href="http://localhost/soc/styleforSignUp.css" rel="stylesheet" type="text/css">	
</head>
<body>
<div class="signupFrm">
    <form action="" class="form" method="POST">
      <h1 class="title">Sign up</h1>      
	
	  <div class="inputContainer">
        <input  class="input" name="login" placeholder="a" value="<?php if(isset($_POST['login'])) { echo htmlentities($_POST['login']); }?>">
        <label for="" class="label" >Login</label>
      </div>
	 
      <div class="inputContainer">
        <input  class="input" name="name" placeholder="a" value="<?php if(isset($_POST['name'])) { echo htmlentities($_POST['name']); }?>">
        <label for="" class="label" >Username</label>
      </div>
	  
	   <div class="inputContainer">
        <input  class="input" name="surname" placeholder="a" value="<?php if(isset($_POST['surname'])) { echo htmlentities($_POST['surname']); }?>">
        <label for="" class="label" >Surname</label>
      </div>

      <div class="inputContainer">
        <input type="text" class="input" name="password" placeholder="a" value="<?php if(isset($_POST['password'])) { echo htmlentities($_POST['password']); }?>">
        <label for="" class="label">Password</label>
      </div>

      <div class="inputContainer">
        <input type="text" class="input" placeholder="a" name="confirm" value="<?php if(isset($_POST['confirm'])) { echo htmlentities($_POST['confirm']); }?>">
        <label for="" class="label" value="<?php if(isset($_POST['confirm'])) { echo htmlentities($_POST['confirm']); }?>">Confirm Password</label>
      </div>
	  <div class="inputContainer">                  
                <input type="date" id="dt" name="birthdate" class="input" value="<?php if(isset($_POST['birthdate'])) { echo htmlentities($_POST['birthdate']); }?>" placeholder="a">                       
        </div>	
		<div class="inputContainer">                  
                <input type="file" name="img_file" class="input" placeholder="a">                       
        </div>	
		
      <input type="submit" class="submitBtn" value="Sign up" name="reg">
	   <div class="text-center">Already have an account? <a href="login1.php">Sign in</a></div>
    </form>
  </div>
</body>
</html>

<?php
	include "db_connect.php";
	$link = db_connect::LinkConnection();
	
	if(isset($_REQUEST['reg'])) {
        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['confirm']) &&
            !empty($_POST['name']) && !empty($_POST['surname'])&& !empty($_POST['birthdate'])) {            
            if ($_POST['password'] == $_POST['confirm']) {
                if(preg_match("/^[A-Za-z0-9]+$/", $_POST['login']) &&
                preg_match("/^[A-Za-z0-9]+$/", $_POST['password'])) {
                    session_start();

                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);					
                    $login = mb_strtolower($_POST['login']);
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];                   
                    $date = date('Y-m-d', strtotime($_POST['birthdate']));
					$img = $_POST['img_file'];
					
                    $_SESSION['auth'] = $login;

                    $query = "SELECT * FROM users WHERE login='$login'";
                    $user = mysqli_fetch_assoc(mysqli_query($link, $query));
					#move_uploaded_file($_FILES["$img"]["tmp_name"], "/files/".$_FILES["$img"]["name"]);
					#$path_file = "/files/".$_FILES["$img"]["name"];
                    
                    if (empty($user)) {
                        $query = "INSERT INTO users SET login='$login', password='$password',
                                name='$name', surname='$surname', date='$date', status='user', banned='0', img_file='$img'";
                        mysqli_query($link, $query);
                        
                        $_SESSION['auth'] = $login;
                        
                        $id = mysqli_insert_id($link);
                        $_SESSION['id'] = $id; // пишем id в сессию
                        $_SESSION['status'] = $user['status']; // записываем статус
                        
                        header("Location: login1.php");
                    } else {
                        echo "Login is not available";
                    }
                } else echo "You can enter only latin letters in lowercase and digits(with no spaces)";
            } else {
                echo "Data entered incorrectly";
            }
        } else echo "You need to fill in all the fields";
    }
?>