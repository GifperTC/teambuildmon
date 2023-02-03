<?php
session_start();

unset($_SESSION['login_id']);
unset($_SESSION['login_username']);
unset($_SESSION['login_email']);
session_destroy(); //delete session

header("refresh:1; url=index.php?page=home");


?>