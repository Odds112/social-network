<?php
    class db_connect {
        static function LinkConnection(){
            $host = 'localhost';
            $user = 'root';
            $pass = '';
            $name = 'User';
            return mysqli_connect($host, $user, $pass, $name);
        }
    }
?>