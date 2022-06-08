<?php
    include "db_connect.php";
?>
<?php
    $link = db_connect::LinkConnection();

    session_start();
	$id = $_SESSION['id'];
	$query = "SELECT * FROM users WHERE id='$id'";
	
	$result = mysqli_query($link, $query);
	$user = mysqli_fetch_assoc($result);

	if (!empty($_POST['submit'])) {
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$middle_name = $_POST['middle_name'];
		$date = $_POST['date'];
        $status = $user['status'];
		$img = $_POST['img_file'];
		
		
		$query = "UPDATE users SET name='$name', surname='$surname',
                  date='$date', status='$status', img_file='$img' WHERE id=$id";
		mysqli_query($link, $query);
	}
?>

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
    if(isset($_REQUEST['change_password'])) {
        header("Location: change_password.php");
    }
    if(isset($_REQUEST['delete_account'])) {
        header("Location: delete_account.php");
    }
?>

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
                <input type="submit" class="submitBtn" value = "Change password" name="change_password">
                <input type="submit" class="submitBtn" value = "Delete account" name="delete_account">
			</form>
		</div>
			
		<div class="container">
	        <div class="header">
		        <h2>Account</h2>
	        </div>
	    <form class="form" id="form" action="" method="POST">
                <div class="form-control">
                    <label for="name">Login</label>
                    <input name="name" id="name" value="<?= $user['name'] ?>">

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                    
                </div>

                <div class="form-control">
                    <label for="surname">Surname</label>
                    <input name="surname" id="surname" value="<?= $user['surname'] ?>">

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                   
                </div>                
               
                
                <div class="form-control">
                    <label for="d">Date</label>
                    <input type="date" name="date" id="d" value="<?= $user['date'] ?>">

                    <i class="fas fa-check-circle"></i>
                    <i class="fas fa-exclamation-circle"></i>
                   
                </div>
				
				<div>
					<img src="<?= $user['img_file'] ?>" width="100" height="100" >
				</div>
				
				<div class="inputContainer">                  
					<input type="file" name="img_file" class="input" placeholder="a">                       
				</div>	
                
                <div class="button">
                    <input type="submit" name="submit" value="Change">
				</div>                
            </form>
        </div>
	</body>
</html>