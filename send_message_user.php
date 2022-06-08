<?php
    include "db_connect.php";
    session_start();
?>
<?php
    $link = db_connect::LinkConnection();

    $id = $_SESSION['id'];
    $id_user = $_SESSION['id_user'];

    if (isset($_POST['message']) && isset($_REQUEST['send_message']) && $_POST['message'] != null)
    {
        $mess = $_POST['message'];
        $query = "INSERT INTO sndb SET uid = '$id', did = '$id_user', text = '$mess', time = '" . time() ."'";
        mysqli_query($link, $query);

        header('Location message.php?id='.$id);
    }
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
                    <input type="submit" class="submitBtn" value = "Profile" name="profile">
                </form>
            
		</div>
		<div class="container profile">
			<div class="header">
				<h2>Profile</h2>
			</div>
			<form class="form" id="form" action="" method="POST">
                <div>
                    <?php
                        $link = db_connect::LinkConnection();
                        $query_message = "SELECT * FROM sndb WHERE uid = {$id} AND did = {$id_user} ORDER BY time DESC";
                        $result_message = mysqli_query($link, $query_message);
                        while ($messages = mysqli_fetch_assoc($result_message)) {
                            $query_users1 = "SELECT * FROM users WHERE id = '$messages[uid]'";
                            $result_users1 = mysqli_query($link, $query_users1);
                            $user1 = mysqli_fetch_assoc($result_users1);

                            $query_users2 = "SELECT * FROM users WHERE id = '$messages[did]'";
                            $result_users2 = mysqli_query($link, $query_users2);
                            $user2 = mysqli_fetch_assoc($result_users2);
                            
                            echo "From: {$user1['name']}". " " ."{$user1['surname']}" . '<br />' . PHP_EOL;
                            echo "to: {$user2['name']}". " " ."{$user2['surname']}" . '<br />' . PHP_EOL;


                            echo htmlspecialchars($messages['text']) . '<br />' . PHP_EOL;
                            echo date('H:i:s', $messages['time']) . '<hr />' . PHP_EOL;
                        } 
                    ?>
                </div>

                <div class="form-control">
                    <form action="" method="POST">
                        <?php 
                            if($_SESSION['id'] != $_GET['id']) {
                        ?>
                        <textarea name="message"></textarea><br />
                        <input type="submit" name="send_message" value="Send message" />
                        <?php } ?>
                    </form><br />
				</div>

                
			</form>
		</div>
	</body>
</html>

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
    if(isset($_REQUEST['profile'])) {
        header("Location: profile.php?id={$_SESSION['id']}");
    }

?>

