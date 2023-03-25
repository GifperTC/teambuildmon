<?php
session_start();
include("inc_connect.php");

$email = $_GET['email'];
$username = $_GET['username'];

$rstchk = mysqli_query($conn, " Select mem_email From member Where mem_email='$email' ");  // Check duplicate Email
$rowchk = mysqli_num_rows($rstchk); 
if ( $rowchk > 0 ) {
    echo "Email";
} else {
    $rstchk = mysqli_query($conn, " Select mem_username From member Where mem_username='$username' ");  // Check duplicate Username
    $rowchk = mysqli_num_rows($rstchk); 
    if ( $rowchk > 0 ) {
        echo "Username";
    } else {
        echo "No";
    }
}

mysqli_close($conn);
?>