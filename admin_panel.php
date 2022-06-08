<?php
    include "db_connect.php";
?>
<?php
    $link = db_connect::LinkConnection();

    function LoadDataAdmins($link) // Загрузка списка юзеров
    {
        $query = "SELECT * FROM users WHERE status='admin'";
        $result = mysqli_query($link, $query);
        while($user = mysqli_fetch_assoc($result)) {
            echo "<tr><td><a href=\"admin_profile.php?id=".$user['id']."\">".$user['id']." ".$user['name']." ".$user['surname']." ".$user['middle_name'].$user['date']."<br/>"."</a></td></tr>";
        }
        while($user = mysqli_fetch_assoc($result));
    }
    function LoadDataUsers($link) // Загрузка списка юзеров
    {
        $query = "SELECT * FROM users WHERE status='user'";
        $result = mysqli_query($link, $query);
        while($user = mysqli_fetch_assoc($result)) {
            echo "<tr><td><a href=\"admin_profile.php?id=".$user['id']."\">".$user['id']." ".$user['name']." ".$user['surname'].$user['date']."<br/>"."</a></td></tr>";
        }
    }
    if(isset($_REQUEST['logout'])) {
        header("Location: logout.php");
    }
    if(isset($_REQUEST['main_page'])) {
        header("Location: main_page.php");
    }
?>
<form action="" method="POST">
    <h1>Admins:</h1><br/>
    <?php LoadDataAdmins($link);?><br/>

    <h2>Users:</h2><br/>
    <?php LoadDataUsers($link);?><br/>

    <input type="submit" value = "Make user" name="make_user">
    <input type="submit" value = "Make admin" name="make_admin"><br/>   

    <input type="submit" value = "Sign out" name="logout">
    <input type="submit" value = "Main" name="main_page">
</form>