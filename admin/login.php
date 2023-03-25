<?php
session_start();
include("../inc_connect.php");

$error = "";

if ( isset($_POST['email']) and isset($_POST['password']) ) {
    $email = mysqli_real_escape_string($conn, $_POST['email']) ;
    $password = sha1(mysqli_real_escape_string($conn, $_POST['password']));

    $sql = "Select * From member Where mem_email='$email' And mem_password='$password'";
    $rst = mysqli_query($conn, $sql);
    $arr = mysqli_fetch_array($rst);

    if (isset($arr['mem_id'])) {

        if ($arr['role'] == "admin") {
            $_SESSION['login_id'] = $arr['mem_id'];
            $_SESSION['login_username'] = $arr['mem_username'];
            $_SESSION['login_role'] = $arr['role'];
            header("refresh:1; url=index.php");
            mysqli_close($conn);
            exit();
        } else {
            $error = "*You don't have permission !";
        }
        
    } else {
        $error = "*Please input password again";
    } 
}

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <title>Admin :: TeamBuildmon</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../js/bootstrap.bundle.js"></script>
</head>

<body class="bg-dark">

    <form action="" method="post">
        <div class="border rounded bg-white p-3 m-3 mx-auto text-center form-control" style="width:500px;">

            <h3 class="mb-3"> System Admin </h3>

            <h2 class="text-primary mb-3"> TeamBuildmon.com </h2>

            <div class="mb-3"><img src="../images/logo1.png" style="width:50px;"></div>

            <input type="email" name="email" class="form-control" placeholder="Email">

            <input type="password" name="password" class="form-control mt-4" placeholder="Password">
            <div class="small text-danger"> <?php echo($error) ?> </div>

            <button type="submit" class="btn btn-primary w-100 my-4"> <i class="fa-solid fa-key"></i> &nbsp; Login </button>

        </div>
    </form>
</body>

</html>
<?php mysqli_close($conn); ?>