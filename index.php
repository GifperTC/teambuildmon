<?php
session_start();
include("inc_connect.php");

//Sign up
if (isset($_POST['signup_submit'])) {
    // && isset($_POST['username']) && isset($_POST['password']
    if (
        isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['cpassword'])
        && strlen($_POST['email']) && strlen($_POST['username']) && strlen($_POST['password']) && strlen($_POST['cpassword'])
    ) {

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

        if ($password == $cpassword) {   // Confirm password correct

            $password = sha1($password); //เข้ารหัสด้วย sha1()
            echo "<script> alert('Sign in successful!'); </script>";

            $sql = "Insert Into member ( mem_username, mem_email, mem_password) 
                values ( '$username', '$email', '$password')";

            mysqli_query($conn, $sql);
        } else { // Confirm password wrong
            echo "<script> alert('Please enter the same password'); </script>";
        }
    } else { // Empty fields
        echo "<script> alert('Please fill in every field'); </script>";
    }

    header("refresh:1; url=?page=team");
    exit();
}

//Login
if (isset($_POST['login_submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = sha1(mysqli_real_escape_string($conn, $_POST['password'])); //เข้ารหัสด้วย sha1()

    $sql = " Select * From member Where mem_username = '$username' And mem_password = '$password' ";
    $rst = mysqli_query($conn, $sql);
    $arr = mysqli_fetch_array($rst);
    if (isset($arr['mem_id'])) {   //กรณีรหัสถูกต้อง
        $_SESSION['login_id']       = $arr['mem_id'];     //เก็บข้อมูลผู้เข้าระบบใส่ตัวแปร
        $_SESSION['login_username'] = $arr['mem_username'];
        $_SESSION['login_email']    = $arr['mem_email'];
    } else {
        echo "<script> alert('Incorrect password!'); </script>";
    }
    header("refresh:1; url=?page=team");
    exit();
}

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</head>

<body>

    <form action="" method="post">

        <div class="modal fade" id="ModalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Login</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Username
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control form-control-sm mt-2 mb-3">
                        Password
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-sm mt-2 mb-3">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ModalSignup"> Signup </button>

                        <button type="submit" name="login_submit" class="btn btn-primary btn-sm">Login</button>

                    </div>
                </div>
            </div>
        </div>

    </form>

    <form action="" method="post">

        <div class="modal fade" id="ModalSignup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Sign in</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Email
                        <input type="text" name="email" id="email" placeholder="Email" class="form-control form-control-sm mt-2 mb-3">
                        Username
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control form-control-sm mt-2 mb-3">
                        Password
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-sm mt-2 mb-3">
                        Confirm Password
                        <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="form-control form-control-sm mt-2 mb-3">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target='#ModalLogin'>Back to Login</button>
                        <button type="submit" name="signup_submit" class="btn btn-warning btn-sm">Sign up</button>

                    </div>
                </div>
            </div>
        </div>

    </form>

    <header>
        <div id="headtopic" class=""> TeamBuildmon </div>
    </header>


    <nav class="navbar navbar-expand-sm m-0 p-1 text-white">
        <div class="container-fluid">
            <img src="images/logo1.png" id="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-white" href="?page=home">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="?page=team">Team Planner</a></li>
                </ul>
                <div>
                    <?php
                    if (isset($_SESSION['login_username'])) {
                        echo $_SESSION['login_username'];
                        echo "<a href='logout.php' class='ms-2 text-white' title='Logout'>[Logout]</a>";
                    } else {
                        echo "<button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#ModalLogin'>Login</button> &nbsp;";
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- White content box-->
    <section>
        <div class="container-md">
            <div class="bg-white border rounded mt-3 mb-3 p-2"> <!--  style="min-height: 600px; overflow-y: auto; overflow-x: hidden;" -->
                <?php
                $page = "home.php";
                if (isset($_GET['page']))
                    $page = $_GET['page'] . ".php";
                include($page);
                ?>
            </div>
        </div>
    </section>

    <footer>
        All content & design &copy; Pokémon Database, 2008-2023. Pokémon images & names &copy; 1995-2023 Nintendo/Game Freak.
    </footer>

</body>

</html>
<?php mysqli_close($conn); ?>