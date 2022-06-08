<?php
    include "db_connect.php";
?>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td>Name</td>
    <td>Surname</td>
    <td>Middle name</td>
    <td>Date(Age)</td>
  </tr>
  <tr>
    <?php
        $link = db_connect::LinkConnection(); 
        CurrentUser($_GET['id'], $link); 
    ?>
  </tr>
</table>
<form action="" method="POST">
    <?php 
        session_start();
        GetStatus($link);
        if (!empty($_SESSION['auth']) && $_SESSION['status'] === 'admin') { 
    ?>
            <input type="submit" value = "Make user" name="make_user">
    <?php
        } else {
    ?>
            <input type="submit" value = "Make admin" name="make_admin">
    <?php
        }
    ?>

    <?php 
        GetStatus($link);
        if (!empty($_SESSION['auth']) && $_SESSION['banned'] === '0') { 
    ?>
            <input type="submit" value = "Ban" name="ban">
    <?php
        } else {
    ?>
            <input type="submit" value = "Unban" name="unban">
    <?php
        }
    ?>
    <input type="submit" value = "Delete" name="delete">
</form>

<?php
    function GetStatus($link) {
        $id_user = $_GET['id'];
        $query = "SELECT * FROM users WHERE id='$id_user'";
        $result = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($result);
        $_SESSION['status'] = $user['status'];
        $_SESSION['banned'] = $user['banned'];
    }
    if (!empty($_POST['delete'])) DeleteAccount($link);
    function DeleteAccount($link) {
        $id = $_GET['id'];
        $query = "SELECT * FROM users WHERE id='$id'";
        
        $result = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($result);
        $query = "DELETE FROM users WHERE id='$id'";
        mysqli_query($link, $query);
        header("Location: admin_panel.php");
    }
    
    function CurrentUser($id_user, $link) //Вывод инфы по конкретному пользователю
    {
        if(empty($_GET['id']))
        {
            echo "Юзер не выбран";
        }
        else
        {
            $id_user = $_GET['id'];

            $query = "SELECT * FROM users WHERE id='$id_user'";
            $result = mysqli_query($link, $query);
            $user = mysqli_fetch_assoc($result);

            $name = $user['name'];
            $surname = $user['surname'];
            $middle_name = $user['middle_name'];
            $date = $user['date'];
            $banned = $user['banned'];
            $status = $user['status'];

            if (isset($_REQUEST['make_user'])) {
                $status = 'user';
                
                $query = "UPDATE users SET name='$name', surname='$surname', middle_name='$middle_name',
                          date='$date', banned='$banned', status='$status' WHERE id=$id_user";
                mysqli_query($link, $query);
            }
            if (isset($_REQUEST['make_admin'])) {
                $status = 'admin';
                
                $query = "UPDATE users SET name='$name', surname='$surname', middle_name='$middle_name',
                          date='$date', banned='$banned', status='$status' WHERE id=$id_user";
                mysqli_query($link, $query);
            }

            if (isset($_REQUEST['ban'])) {
                $banned = '1';
                
                $query = "UPDATE users SET name='$name', surname='$surname', middle_name='$middle_name',
                          date='$date', banned='$banned', status='$status' WHERE id=$id_user";
                mysqli_query($link, $query);
            }

            if (isset($_REQUEST['unban'])) {
                $banned = '0';
                
                $query = "UPDATE users SET name='$name', surname='$surname', middle_name='$middle_name',
                          date='$date', banned='$banned', status='$status' WHERE id=$id_user";
                mysqli_query($link, $query);
            }

            printf ("
                <td>".$user['name']."</td>
                <td>".$user['surname']."</td>
                <td>".$user['middle_name']."</td>
                <td>".$user['date']."</td>
            ");
        }
    }

?>

<?php
    if(isset($_REQUEST['logout'])) {
        header("Location: logout.php");
    }
    if(isset($_REQUEST['main_page'])) {
        header("Location: main_page.php");
    }
    if(isset($_REQUEST['admin_panel'])) {
        header("Location: admin_panel.php");
    }
?>

<form action="" method="GET">
	<input type="submit" value = "Sign out" name="logout">
    <input type="submit" value = "Main" name="main_page">
    <input type="submit" value = "Admin panel" name="admin_panel">
</form>