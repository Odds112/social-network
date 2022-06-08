<?php
    include "db_connect.php";
?>
<?php
    function LoadDataUsers() // Загрузка списка юзеров
    {
        $link = db_connect::LinkConnection();

        $query = "SELECT id, name, surname, date from users";
        $result = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($result);
        do
        {
            echo "<tr><td><a href=\"profile.php?id=".$user['id']."\">".$user['id']." ".$user['name']." ".$user['surname'].$user['date']."<br/>"."</a></td></tr>";
        }
        while($user = mysqli_fetch_assoc($result));
    }
?>
<form action="" method="POST">
    <?php LoadDataUsers();?>
</form>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>List of users</title>
	<style>
	html {
		background-color: #56baed;
		}
	</style>	
</head>
<body>
</body>
</html>