<?php
    include "db_connect.php";
?>
<form action="" method="POST">
    <label for="p1">Password: </label>
	<input type="password" name="password" id="p1">

	<input type="submit" name="submit">

    <input type="submit" class="submitBtn"  value = "Sign out" name="logout">
    <input type="submit" value = "Main" name="main_page">
    <input type="submit" value = "Users" name="users">
</form>
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
    $link = db_connect::LinkConnection();

    session_start();
	$id = $_SESSION['id'];
	$query = "SELECT * FROM users WHERE id='$id'";
	
	$result = mysqli_query($link, $query);
	$user = mysqli_fetch_assoc($result);
	if (!empty($_POST['submit'])) {
	    $hash = $user['password']; // соленый пароль из БД
        // Проверяем соответствие хеша из базы введенному старому паролю
        if (password_verify($_POST['password'], $hash)) {
            $query = "DELETE FROM users WHERE id='$id'";
            mysqli_query($link, $query);
            header("Location: logout.php");
        } else {
            //  пароль введен неверно, выведем сообщение
        }
    }
?>
