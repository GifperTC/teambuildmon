<?php

//1) เชื่อมต่อไปยังฐานข้อมูลด้วยคำสั่ง mysqli_connect("ชื่อเซิร์ฟเวอร์", "ชื่อผู้ใช้", "รหัสผ่าน", "ชื่อฐานข้อมูล")

// LOCAL
$conn = @mysqli_connect("localhost", "root", "", "teambuildmondb") or die('Connection failed please wait..');

// $conn = @mysqli_connect("localhost", "teambuild_db", "Team1122%db", "teambuild_db") or die('Connection failed please wait..');

//2) Set ค่าภาษาไทย
mysqli_query($conn, "Set names utf8");

//3) Set time zone
date_default_timezone_set("Asia/Bangkok");

?>