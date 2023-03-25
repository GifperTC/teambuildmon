<?php
session_start();
include("inc_connect.php");

//Sign up
if ( isset($_POST['signup_submit']) && isset($_POST['signup_email'], $_POST['signup_username'], $_POST['signup_password'], $_POST['signup_cpassword'])
    && strlen($_POST['signup_email']) && strlen($_POST['signup_username']) && strlen($_POST['signup_password']) && strlen($_POST['signup_cpassword']) ) {
    
    $signup_email = mysqli_real_escape_string($conn, $_POST['signup_email']);
    $signup_username = mysqli_real_escape_string($conn, $_POST['signup_username']);
    $signup_password = mysqli_real_escape_string($conn, $_POST['signup_password']);
    $signup_cpassword = mysqli_real_escape_string($conn, $_POST['signup_cpassword']);
    $signup_password = sha1($signup_password); //เข้ารหัสด้วย sha1()
    $sql = "Insert Into member ( mem_username, mem_email, mem_password) 
                values ( '$signup_username', '$signup_email', '$signup_password')";
    mysqli_query($conn, $sql);

    //Login now ( get PK)
    $sql = " Select * From member Where mem_username = '$signup_username' And mem_password = '$signup_password' ";
    $rst = mysqli_query($conn, $sql);
    $arr = mysqli_fetch_array($rst);
    if (isset($arr['mem_id'])) {   //กรณีรหัสถูกต้อง
        $_SESSION['login_id']       = $arr['mem_id'];     //เก็บข้อมูลผู้เข้าระบบใส่ตัวแปร
        $_SESSION['login_username'] = $arr['mem_username'];
        $_SESSION['login_email']    = $arr['mem_email'];
    }

    echo "<script> alert('Sign up successful!'); </script>";
    header("refresh:1; url=?page=team");
    mysqli_close($conn);
    exit();
}

//Login
if (isset($_POST['login_submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = sha1(mysqli_real_escape_string($conn, $_POST['password'])); //เข้ารหัสด้วย sha1()

    $sql = " Select * From member Where mem_email = '$email' And mem_password = '$password' ";
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
    mysqli_close($conn);
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

    <!-- Modal :: Login -->
    <form action="" method="post" onsubmit="return CheckLogin()">
        <div class="modal fade" id="ModalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Login</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-1">Email</div>
                        <input type="email" name="email" id="email" placeholder="Email" class="form-control form-control-sm mt-1">
                        <div class="small text-danger ms-2" id="err_login_email" style="display:none;">*Please input your email</div>
                        <div class="small text-danger ms-2" id="err_email_incorrect" style="display:none;">Sorry! Email not found.</div>
                        <div class="mt-3">Password</div>
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-sm mt-1">
                        <div class="small text-danger ms-2" id="err_login_password" style="display:none;">*Please input your password</div>
                        <div class="small text-danger ms-2" id="err_password_incorrect" style="display:none;">Sorry! Password incorrect.</div>
                        <button type="submit" name="login_submit" class="btn btn-primary btn-sm w-100 mt-3 mb-1">Login</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-sm me-auto" data-bs-toggle="modal" data-bs-target="#ModalSignup"> Signup </button>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#ModalForget">[Forget Password]</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal :: Signup -->
    <form action="" id="frm1" method="post" onsubmit="return CheckSignup()">
        <div class="modal fade" id="ModalSignup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Sign Up</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div >Email</div>
                        <input type="email" name="signup_email" id="signup_email" placeholder="Email" class="form-control form-control-sm mt-1">
                        <div class="small text-danger ms-2" id="err_signup_email" style="display:none;">*Please input your email</div>
                        <div class="small text-danger ms-2" id="err_email_duplicate" style="display:none;">Sorry! Duplicate Email.</div>

                        <div class="mt-3">Username</div>
                        <input type="text" name="signup_username" id="signup_username" placeholder="Username" class="form-control form-control-sm mt-1">
                        <div class="small text-danger ms-2" id="err_signup_username" style="display:none;">*Please input your username</div>
                        <div class="small text-danger ms-2" id="err_username_duplicate" style="display:none;">Sorry! Duplicate Username.</div>

                        <div class="mt-3">Password</div>
                        <input type="password" name="signup_password" id="signup_password" placeholder="Password" class="form-control form-control-sm mt-1">
                        <div class="small text-danger ms-2" id="err_signup_password" style="display:none;">*Please input your password</div>
                        <div class="small text-danger ms-2" id="err_signup_password2" style="display:none;">*Password must not be less than 8 characters.</div>

                        <div class="mt-3">Confirm Password</div>
                        <input type="password" name="signup_cpassword" id="signup_cpassword" placeholder="Confirm Password" class="form-control form-control-sm mt-1">
                        <div class="small text-danger ms-2" id="err_signup_cpassword" style="display:none;">*Please confirm your password</div>
                        <div class="small text-danger ms-2" id="err_signup_cpassword2" style="display:none;">*Incorrect password confirmation</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target='#ModalLogin'>Back to Login</button>
                        <button type="submit" name="signup_submit" class="btn btn-warning btn-sm">Sign up</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal :: Forget Password -->
    <div class="modal fade" id="ModalForget" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Forget Password</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="showform">
                        <input type="email" name="emailforget" id="emailforget" placeholder="Email" class="form-control mt-3">
                        <div class="small text-danger ms-2" id="err_email_forget" style="display:none;">Sorry! Email not found.</div>
                        <div class="small text-primary ms-2" id="err_please_input_email">* Please Input Your Registered Email</div>
                        <button type="submit" id="forget_submit" name="forget_submit" class="btn btn-primary btn-sm w-100 mt-5 mb-4">Reset Password</button>
                    </div>
                    <div id="showsending">
                        <div class="text-center my-2">Email Sending Please Wait.....<br><img src="images/sending.gif" height="200"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal :: Reset Password Email Sent -->
    <div class="modal fade" id="ModalForgetEmailSent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Forget Password</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="mt-3 mb-4 text-success">Email Successfully Sent.</h5>
                        <h6 class="mt-3 mb-3">*Please check your mailbox and click the link in your email to reset your password. </h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
    </div>

    <header>
        <div id="headtopic" class=""> TeamBuildmon </div>
    </header>


    <nav class="navbar navbar-expand-sm m-0 p-1 text-white">
        <div class="container-fluid">
            <a href="?page=home"><img src="images/logo1.png" id="logo"></a>
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
                        echo '<button type="button" class="btn btn-warning btn-sm me-auto" data-bs-toggle="modal" data-bs-target="#ModalSignup"> Signup </button>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- White content box-->
    <section>
        <div class="container-md">
            <div class="bg-white border rounded mt-3 mb-3 p-2" style="min-height: 450px;">  <!--  style="min-height: 600px; overflow-y: auto; overflow-x: hidden;" -->
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
        All Pokémon images & names &copy; 1995-2023 Nintendo/Game Freak.
    </footer>

</body>
</html>
<script>

    $("#showsending").hide(500)

    function CheckLogin() {
        
        if (document.getElementById('email').value.trim() == "") {       // check email empty
            document.getElementById('err_login_email').style.display = "block"
            document.getElementById('err_email_incorrect').style.display = "none"
            document.getElementById('email').focus()
            return false
        } else {
            document.getElementById('err_login_email').style.display = "none"
            document.getElementById('err_email_incorrect').style.display = "none"
        }

        if (document.getElementById('password').value.trim() == "") {       // check password empty
            document.getElementById('err_login_password').style.display = "block"
            document.getElementById('err_password_incorrect').style.display = "none"
            document.getElementById('password').focus()
            return false
        } else {
            document.getElementById('err_login_password').style.display = "none"
            document.getElementById('err_password_incorrect').style.display = "none"
        }

        var incorrect = $.CheckLoginPassword();  //Call Ajax 
        if ( incorrect == "Email") {
            document.getElementById('err_email_incorrect').style.display = "block"
            document.getElementById('err_password_incorrect').style.display = "none"
            return false
        } else if ( incorrect == "Password") {
            document.getElementById('err_email_incorrect').style.display = "none"
            document.getElementById('err_password_incorrect').style.display = "block"
            return false
        } else {
            document.getElementById('err_email_incorrect').style.display = "none"
            document.getElementById('err_password_incorrect').style.display = "none"
        }

    }

    function CheckSignup() {
        
        if (document.getElementById('signup_email').value.trim() == "") {    // check email empty
            document.getElementById('err_signup_email').style.display = "block"
            document.getElementById('signup_email').focus()
            return false
        } else {
            document.getElementById('err_signup_email').style.display = "none"
        }

        // check username empty
        if (document.getElementById('signup_username').value.trim() == "") {
            document.getElementById('err_signup_username').style.display = "block"
            document.getElementById('signup_username').focus()
            return false
        } else {
            document.getElementById('err_signup_username').style.display = "none"
        }

        var dup = $.CheckDuplicate();  //Call Ajax
        if ( dup == "Email") {
            document.getElementById('err_email_duplicate').style.display = "block"
            document.getElementById('err_username_duplicate').style.display = "none"
            return false
        } else if ( dup == "Username") {
            document.getElementById('err_email_duplicate').style.display = "none"
            document.getElementById('err_username_duplicate').style.display = "block"
            return false
        } else {
            document.getElementById('err_email_duplicate').style.display = "none"
            document.getElementById('err_username_duplicate').style.display = "none"
        }

        // check password empty
        pass = document.getElementById('signup_password')
        cpass = document.getElementById('signup_cpassword')

        if (pass.value.trim() == "") {
            document.getElementById('err_signup_password').style.display = "block"
            document.getElementById('err_signup_password2').style.display = "none"
            pass.focus()
            return false
        } else {
            document.getElementById('err_signup_password').style.display = "none"
        }
        // check password at least 8 char
        if (pass.value.length > 0 && pass.value.length < 8 ) {
            document.getElementById('err_signup_password2').style.display = "block"
            pass.focus()
            return false
        } else {
            document.getElementById('err_signup_password2').style.display = "none"
        }

        // check cpassword empty
        if (cpass.value.trim() == "") {
            document.getElementById('err_signup_cpassword').style.display = "block"
            cpass.focus()
            return false
        } else {
            document.getElementById('err_signup_cpassword').style.display = "none"
        }

        // check cpassword = password
        if ( cpass.value.trim() != pass.value.trim() ) {
            document.getElementById('err_signup_cpassword2').style.display = "block"
            cpass.focus()
            return false
        } else {
            document.getElementById('err_signup_cpassword2').style.display = "none"
        }

    }

    function CheckForget() {
        if (document.getElementById('emailforget').value.trim() == "") {       // check email empty
            document.getElementById('err_please_input_email').style.display = "block"
            document.getElementById('err_email_forget').style.display = "none"
            document.getElementById('emailforget').focus()
            return false
        } else {
            document.getElementById('err_please_input_email').style.display = "none"
            document.getElementById('err_email_forget').style.display = "none"
        }
        
        var dupforget = $.CheckDupForget();  //Call Ajax 
        if ( dupforget == "No") {
            document.getElementById('err_email_forget').style.display = "block"
            document.getElementById('err_please_input_email').style.display = "none"
            return false
        } else {
            document.getElementById('err_email_forget').style.display = "none"
            document.getElementById('err_please_input_email').style.display = "none"
            if ( !confirm('Reset Now ?')) {
                return false
            } else {
                $("#showform").hide(500);
                $("#showsending").fadeIn(1000, function() {
                    var sent = $.SendEmail();  
                    if ( sent == "Sent") {
                        $('#ModalForget').modal('hide')
                        $('#ModalForgetEmailSent').modal('show')
                    } else {
                        alert('Cannot Send Email!')
                    }
                })
                return false
            }
        }
    }

    $("#forget_submit").click(function(){
        CheckForget();
    })
    
    $.CheckLoginPassword = function () {
        var result = ""
        if ($("#email").val() != "" && $("#password").val() != "") {
            $.ajax('ajax_checkloginpassword.php', {
                type: 'GET',  
                async: false,
                data: { email: $("#email").val().trim(), password: $("#password").val().trim()  },  
                success: function (data, status, xhr) {
                    result = data
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    $("body").html("Cannot call jquery file")
                }
            })
        }
        return result
    }

    $.CheckDuplicate = function () {
        var result = ""
        $.ajax('ajax_checkduplicate.php', {
            type: 'GET',  
            async: false,
            data: { email: $("#signup_email").val().trim(), username: $("#signup_username").val().trim()  },  
            success: function (data, status, xhr) {
                result = data
            },
            error: function (jqXhr, textStatus, errorMessage) {
                $("body").html("Cannot call jquery file")
            }
        })
        return result
    }

    $.CheckDupForget = function () {
        var result = ""
        $.ajax('ajax_checkdupforget.php', {
            type: 'GET',  
            async: false,
            data: { email: $("#emailforget").val().trim()  },  
            success: function (data, status, xhr) {
                result = data
            },
            error: function (jqXhr, textStatus, errorMessage) {
                $("body").html("Cannot call jquery file")
            }
        })
        return result
    }

    $.SendEmail = function () {
        var result = ""
        $.ajax('ajax_forgetemailsend.php', {
            type: 'GET',  
            async: false,
            data: { email: $("#emailforget").val().trim()  },  
            success: function (data, status, xhr) {
                result = data
            },
            error: function (jqXhr, textStatus, errorMessage) {
                $("body").html("Cannot call jquery file")
            }
        })
        return result
    }

</script>

<?php mysqli_close($conn); ?>