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
                <input type="submit" class="submitBtn" value = "Profile" name="profile">						
                <input type="submit" class="submitBtn" value = "Account" name="account">
				

                    <?php 
                        if (!empty($_SESSION['auth']) && $_SESSION['status'] === 'admin') { 
                    ?>
                            <input type="submit" class="submitBtn" value = "Admin panel" name="admin_panel">
                    <?php
                        } else {
                    ?>
                            <input type="submit" class="submitBtn" value = "Users" name="users">
                    <?php
                        }
                    ?>
            </form>
		</div>
		<div class="container profile">
			<div class="header">
				<h2>Create post</h2>
			</div>
			<form class="form" id="form" action="" method="POST">

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

                <div>
                    <?php
                        $link = db_connect::LinkConnection();
                        $count = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(id) as total FROM posts"));
                        echo 'Total posts: ' . $count['total'] . '<br />';

                        $query_posts = "SELECT * FROM posts ORDER BY time DESC";
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

			</form>
		</div>
	</body>
</html>

<?php
    $link = db_connect::LinkConnection();
    if (isset($_POST['message']) && isset($_REQUEST['send_message']) && $_POST['message'] != null)
    {
        $mess = $_POST['message'];
        $id = $_SESSION['id']; // id пользователя который отправляет сообщение
        $query = "INSERT INTO posts SET iduser = '$id', text = '$mess', time = '" . time() ."'";
        mysqli_query($link, $query);

        header('Location profile.php');
    }
?>

<?php // BUTTONS ?>

<?php
    if(isset($_REQUEST['logout'])) {
        header("Location: logout.php");
    }
    if(isset($_REQUEST['profile'])) {
        header("Location: profile.php?id={$_SESSION['id']}");
    }
    if(isset($_REQUEST['users'])) {
        header("Location: users.php");
    }
    if(isset($_REQUEST['account'])) {
        header("Location: account.php");
    }
    if(isset($_REQUEST['admin_panel'])) {
        header("Location: admin_panel.php?id={$_SESSION['id']}");
    }
?>

