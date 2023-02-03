<?php
include("../inc_connect.php");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../js/bootstrap.bundle.js"></script>
</head>
<body>

    <div class="mysidebar close">
        <div class="logo-details">
            <i class="fa fa-bars" aria-hidden="true"></i>
            
            <span class="logo_name">TeamBuildmon</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="?page=dashboard">
                    <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="?page=dashboard">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <a href="?page=monsters">
                    <i class="fa fa-list"></i>
                    <span class="link_name">Monsters</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="?page=monsters">Monsters</a></li>
                </ul>
            </li>
            <li>
                <a href="?page=members">
                    <i class="fa-solid fa-users-rectangle"></i>
                    <span class="link_name">Members</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="?page=members">Members</a></li>
                </ul>
            </li>

            <!-- <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fa fa-sliders" aria-hidden="true"></i>
            <span class="link_name">ตั้งค่า</span>
          </a>
          <i class="fa fa-arrow-circle-o-down arrow" aria-hidden="true"></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">ตั้งค่า</a></li>
          <li><a href="#">UI Face</a></li>
          <li><a href="#">Pigments</a></li>
          <li><a href="#">Box Icons</a></li>
        </ul>
      </li> -->

            <li>
                <div class="profile-details">
                    <a href="signout.php" title="Sign out"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </div>
            </li>
        </ul>
    </div>

    <section class="home-section">

        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="?page=dashboard"><img src="../images/logo1.png" id="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav me-auto">
                        <span class="navbar-text">&nbsp;</span>
                    </ul>
                    <span class="navbar-text"> สมรักษ์ คำสิงห์ &nbsp;[Admin]</span>
                </div>
            </div>
        </nav>

        <div class="home-content">

            <div class="container-fluid">
                <?php 
                
                $page = "dashboard.php";
                if (isset($_GET['page']))
                    $page = $_GET['page'].".php";
                include($page);

                ?>
            </div>

        </div>

    </section>

    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".mysidebar");
        let sidebarBtn = document.querySelector(".fa-bars"); //(".bx-menu"); // console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    </script>


</body>

</html>
<?php mysqli_close($conn); ?>