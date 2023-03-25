<?php
session_start();
include("inc_connect.php");

$email = $_GET['email'];
$password = sha1($_GET['password']);

$rstchk = mysqli_query($conn, " Select mem_email From member Where mem_email='$email' ");  // Check Correct Email
$rowchk = mysqli_num_rows($rstchk); 
if ( $rowchk == 0 ) {
    echo "Email";
} else {
    $rstchk = mysqli_query($conn, " Select mem_password From member Where mem_password='$password' ");  // Check Correct Password
    $rowchk = mysqli_num_rows($rstchk); 
    if ( $rowchk == 0 ) {
        echo "Password";
    } else {
        echo "";
    }
}

mysqli_close($conn);
?>