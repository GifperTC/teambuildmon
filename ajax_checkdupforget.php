<?php
session_start();
include("inc_connect.php");

$email = $_GET['email'];

$rstchk = mysqli_query($conn, " Select mem_email From member Where mem_email='$email' ");  // Check Registered Email
$rowchk = mysqli_num_rows($rstchk); 
if ( $rowchk > 0 ) {
    echo "Email";
} else {
    echo "No";
}

mysqli_close($conn);
?>