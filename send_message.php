<?php
    include "db_connect.php";
    session_start();
?>

<?php
    $link = db_connect::LinkConnection();
    
    $query_users = "SELECT * FROM users WHERE id = '$posts[userId]'";
    $result_users = mysqli_query($link, $query_users);
    $user = mysqli_fetch_assoc($result_users);

    $count = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(id) as total FROM posts WHERE userid = {$_GET['id']}"));
    echo 'Total posts: ' . $count['total'] . '<br />';

    $query_posts = "SELECT * FROM posts WHERE userid = {$_GET['id']} ORDER BY time DESC";
    $result_posts = mysqli_query($link, $query_posts);
    while ($posts = mysqli_fetch_assoc($result_posts)) {
        $query_users = "SELECT * FROM users WHERE id = '$posts[userId]'";
        $result_users = mysqli_query($link, $query_users);
        $user = mysqli_fetch_assoc($result_users);
        
        echo "From: {$user['name']}". " " ."{$user['surname']}" . '<br />' . PHP_EOL;

        echo htmlspecialchars($posts['message']) . '<br />' . PHP_EOL;
        echo date('H:i:s', $posts['time']) . '<hr />' . PHP_EOL;
    } 
?>

<form action="" method="POST">
    <?php 
        if($_SESSION['id'] == null) {
    ?>
    <textarea name="message"></textarea><br />
    <input type="submit" name="send_message" value="Send message" />
    <?php } ?>
</form><br />

<?php
    $link = db_connect::LinkConnection();
    if (isset($_POST['message']) && isset($_REQUEST['send_message']) && $_POST['message'] != null)
    {
        $mess = $_POST['message'];
        $id = $_SESSION['id']; // id пользователя который отправляет сообщение
        $query = "INSERT INTO posts SET userId = '$id', message = '$mess', time = '" . time() ."'";
        mysqli_query($link, $query);

        header('Location profile.php?id="'.$id.'\"');
    }
?>
