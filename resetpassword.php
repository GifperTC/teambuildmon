<?php
if (!isset($_GET['id']) )  {
    header("refresh:1; url=index.php");
    exit();
}
include("inc_connect.php");

$id = $_GET['id'];
$success = "No";

//Reset Password
if ( isset($_POST['submit']) And isset($_POST['newpassword'])) {
    $newpassword = sha1($_POST['newpassword']);
    $sql = "Update member Set mem_resetcode= null, mem_password='$newpassword' Where mem_resetcode='$id' And mem_resetcode is not null ";
    mysqli_query($conn, $sql);
    $success = "Yes";
} else {
    $sql = " Select mem_email From member Where mem_resetcode = '$id' And mem_resetcode is not null ";
    $rst = mysqli_query($conn, $sql);
    $arr = mysqli_fetch_array($rst);
    if (!isset($arr['mem_email'])) { 
        echo "<script> alert('ไม่พบข้อมูล !'); </script>";
        echo "<script> window.location='index.php'; </script>";
        exit();
    }
}
?>

    <title> Reset Password </title>

    <h3 class="text-center pt-4 pb-4">Reset Password</h3>

    <form action="" id="frmPass" method="post">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8">

                <?php if ( $success == "No") { ?>
                    <div class="mt-3">New Password:</div>            
                    <input type="password" name="newpassword" id="newpassword" class="form-control">
                    <div class="ms-2 small text-danger" id="err1" style="display:none;">*Please input new password as least 8 characters.</div>
                    <div class="mt-3">Confirm Password:</div>            
                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
                    <div class="ms-2 small text-danger" id="err2" style="display:none;">*Confirm password does not match.</div>
                    <button type="submit" name="submit" id="submit" class="btn btn-primary mt-4 mb-2"> Save New Password </button>
                <?php } elseif ($success == "Yes") { ?>
                    <h3 class="pt-4 text-success">Your Password has been successfully reset. <br> You can now log in with your new password.</h3>
                <?php } ?>

            </div>
            <div class="col-lg-3 col-md-2"></div>
        </div>
    </form>


<script>
$(document).ready(function(){

   $("#frmPass").submit(function(){
        if ( $("#newpassword").val().trim()=="" || $("#newpassword").val().length < 8) {
            $("#err1").css("display", "block")
            $("#newpassword").focus()
            return false
        } else {
            $("#err1").css("display", "none")
        }
        if ( $("#newpassword").val().trim() != $("#confirmpassword").val().trim()) {
            $("#err2").css("display", "block");
            $("#confirmpassword").focus()
            return false
        } else {
            $("#err2").css("display", "none");
        }
        if (!confirm('Reset Password Now ?')) return false;
   })

})
</script>

