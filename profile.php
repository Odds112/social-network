<?php
    include "db_connect.php";
    session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Profile</title>
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
                    <input type="submit" class="submitBtn" value = "Send Message" name="send_message_user">
            </form>
		</div>
		<div class="container profile">
			<div class="header">
				<h2>Profile</h2>
			</div>
			<form class="form" id="form" action="" method="POST">
            <div class="form-control">
                    <table width="100%" border="1" cellspacing="0" cellpadding="5">
                    <tr>
                        <td>Name</td>
                        <td>Surname</td>                        
                        <td>Date(Age)</td>
                    </tr>
                    <tr>
                        <?php CurrentUser($_GET['id']); ?>
                    </tr>
                    </table>
				</div>

                <div>
                    <?php
                        $link = db_connect::LinkConnection();
                        $count = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(id) as total FROM posts WHERE iduser = {$_GET['id']}"));
                        echo 'Total posts: ' . $count['total'] . '<br />';

                        $query_posts = "SELECT * FROM posts WHERE iduser = {$_GET['id']} ORDER BY time DESC";
                        $result_posts = mysqli_query($link, $query_posts);
                        while ($posts = mysqli_fetch_assoc($result_posts)) {
                            $query_users = "SELECT * FROM users WHERE id = '$posts[iduser]'";
                            $result_users = mysqli_query($link, $query_users);
                            $user = mysqli_fetch_assoc($result_users);
                            
                            echo "From: {$user['name']}". " " ."{$user['surname']}" . '<br />' . PHP_EOL;

                            echo htmlspecialchars($posts['text']) . '<br />' . PHP_EOL;
                            echo date('H:i:s', $posts['time']) . '<hr />' . PHP_EOL;
                        } 
                    ?>
                </div>

				
                <div class="form-control">
                    <form class="mes" action="" method="POST">
                        <?php 
                            if($_SESSION['id'] == $_GET['id']) {
                        ?>
                        <textarea name="message"></textarea><br />
                        <div class="button">
                            <input type="submit" name="send_message" value="Send post" />
                        </div>
                        <?php } ?>
                    </form><br />
				</div>
			</form>
		</div>
	</body>
</html>

<?php
    function CurrentUser($id_user) //Вывод инфы по конкретному пользователю
    {
        $link = db_connect::LinkConnection();

        if(empty($_GET['id']))
        {
            echo "Юзер не выбран";
        }
        else
        {
            $id_user = $_GET['id'];
            $_SESSION['id_user'] = $id_user;

            $query = "SELECT * FROM users WHERE id='$id_user'";
            $result = mysqli_query($link, $query);
            $user = mysqli_fetch_assoc($result);

            printf ("
                <td>".$user['name']."</td>
                <td>".$user['surname']."</td>                
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
        header("Location: main_page.php?id={$_SESSION['id']}");
    }
    if(isset($_REQUEST['users'])) {
        header("Location: users.php?id={$_SESSION['id']}");
    }
    if(isset($_REQUEST['send_message_user'])) {
        header("Location: send_message_user.php?id={$_SESSION['id_user']}");
    }
?>

<?php // POSTS ?>

<?php
    $link = db_connect::LinkConnection();
    if (isset($_POST['message']) && isset($_REQUEST['send_message']) && $_POST['message'] != null)
    {
        $mess = $_POST['message'];
        $id = $_SESSION['id']; // id пользователя который отправляет сообщение
        $query = "INSERT INTO posts SET userId = '$id', message = '$mess', time = '" . time() ."'";
        mysqli_query($link, $query);

        header("Location profile.php?id={$_SESSION['id']}");
    }
?>