<?php

if (!isset($_SESSION['login_id']) or $_SESSION['login_role'] != "admin") {
    header("refresh:1; url=login.php");
    exit();
 }

?>

<title> Members </title>

<div class="row">
    <div class="col-12">

        <div class="bg-white rounded border my-4 p-3">
            <h3 class="pt-2 pb-3"> <i class="fa-solid fa-users-rectangle text-primary"></i> Members list</h3>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered" style="font-size: 13px;">
                    <tr class="table-primary">
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                    <?php
                    $sql = " Select * From member ";
                    $sql .= " Order by mem_id Asc ";

                    $rst = mysqli_query($conn, $sql);
                    while ($arr = mysqli_fetch_array($rst)) 
                    {
                    ?>
                    <tr>
                        <td> <?php echo $arr["mem_id"] ?> </td>
                        <td> <?php echo $arr["mem_username"] ?> </td>
                        <td> <?php echo $arr["mem_email"] ?> </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>

    </div>
</div>