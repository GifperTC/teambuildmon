<?php
session_start();
include("inc_connect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_GET['email']) )  {
    echo "No";
    exit();
}

$username = "giftbbt@gmail.com";  //อีเมล์ใช้ส่ง
$password = "pdfqfjbstcvrnxav";  //รหัสใช้ส่ง
$server = "http://localhost/TeamBuildmon.com/";   //ชื่อเว็ปเช่น https://teambuildmon.com


$email = $_GET['email'];
$resetcode = substr(md5(microtime()),rand(0,26),10);
$path = $server."?page=resetpassword&id=".$resetcode;
mysqli_query($conn, "Update member Set mem_resetcode = '$resetcode' Where mem_email='$email' ");
mysqli_close($conn);

try {
    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    $mail->IsMail();  //$mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug = 0; //1=Show Debug
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->IsHTML(true);
    $mail->AddAddress($email, "Member");
    $mail->AddCC($username, $username);
    $mail->SetFrom($username, "TeamBuildMon.com");
    $mail->Subject = "TeamBuildMon.com :: Reset Password";
    $content = "
        <h4>---- Reset Member Password ----</h4><br>
        Please click link below to reset password::<br><br>
        $path
        <br><br>
        Thank you.<br>
        TeamBuildMon Team.<br><br>
        ";
    $mail->MsgHTML($content);
    $mail->Send();
    echo "Sent";
} catch (Exception $e) {
    echo "No";    //echo "อีเมลส่งไม่ได้เนื่องจาก: {$mail->ErrorInfo}";
}
?>