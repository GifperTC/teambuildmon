<?php
if ( !isset($_SESSION['login_id']) or $_SESSION['login_role'] != "admin" ) {
    header("refresh:1; url=login.php");
    exit();
}
?>

<title> Monsters </title>

<div class="row">
    <div class="col-12">

        <div class="bg-white rounded border my-4 p-3">

            <h3 class="pt-2 pb-3"> <i class="fa fa-list text-danger"></i> Pokemon list</h3>

            <!-- Search bar -->
            <form action="" method="get">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-3">
                                <input type="hidden" name="page" value="monsters">
                                <input type="text" class="form-control form-control-sm mb-3" name="keyword" id="keyword" value="<?php if( isset($_GET["keyword"]) ) echo $_GET["keyword"] ?>">
                            </div>
                            <div class="col-3">
                                <select class="form-select form-select-sm" name="type" id="type">
                                    <option value="">--All Type--</option>
                                    <?php
                                    $rsttype = mysqli_query($conn, " Select * From type Order By type_name Asc ");
                                    while ($arrtype = mysqli_fetch_array($rsttype)) {
                                            echo "<option value='".strtolower($arrtype['type_name'])."' ";
                                            if (isset($_GET['type']) and (ucfirst($_GET['type'])) == $arrtype['type_name']) echo "selected";
                                            echo "> ".$arrtype['type_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-select form-select-sm" name="game_id" id="game_id">
                                    <option value="">--All Game--</option>
                                    <?php
                                    $rstgame = mysqli_query($conn, " Select * From game Order by game_id Asc");
                                    while ($arrgame = mysqli_fetch_array($rstgame)) {
                                        echo "<option value='".$arrgame['game_short']."' ";
                                        if (isset($_GET['game_id']) and ($_GET['game_id']) == $arrgame['game_short']) echo "selected";
                                        echo ">".$arrgame['game_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-success btn-sm" id=""> Search </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="?page=monsters_insert" class="btn btn-primary btn-sm float-end"> เพิ่ม Monster </a>
                    </div>
                </div>
            </form>

            <!-- End Search bar -->

            <!--Table -->
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered" style="font-size: 12px;">
                    <tr class="table-danger">
                        <!-- <th>ID</th> -->
                        <th>Image</th>
                        <th>Image</th>
                        <th>Name (EN)</th>
                        <th>Name (JP)</th>
                        <th>Primary type</th>
                        <th>Secondary type</th>
                        <th>Base egg steps</th>
                        <th>Capture rate</th>
                        <th>Exp growth</th>
                        <th>HP</th>
                        <th>Attack</th>
                        <th>Defense</th>
                        <th>Special Attack</th>
                        <th>Special Defense</th>
                        <th>Speed</th>
                        <th>Totol</th>
                        <th>LGPE</th>
                        <th>SWSH</th>
                        <th>BDSP</th>
                        <th>PLA</th>
                        <th>SV</th>
                        <th>Edit</th>
                    </tr>
                    <?php

                    $sql = " Select * From mon_data Where 1 ";

                    // check if there is a keyword sent from search bar 
                    if ( isset($_GET['keyword']) ) {
                        $keyword = $_GET['keyword'];

                        // query for word that include the keyword 
                        $sql .= " And name like '%$keyword%' ";
                    }

                    // check if there is a type sent from dropdown
                    if ( isset($_GET['type']) and $_GET['type'] != "" ) {
                        $type = $_GET['type'];

                        // query for word that include the type 
                        $sql .= " And (type1 like '%$type%' Or type2 like '%$type%' )  ";
                    }

                    // check if there is a game_short sent from dropdown
                    if ( isset($_GET['game_id']) and $_GET['game_id'] != "" ) {
                        $game_id = $_GET['game_id'];

                        // query for word that include the type 
                        $sql .= " And $game_id = 'Y' ";
                    }

                    $sql .= " Order By Name Asc";

                    $rst = mysqli_query($conn, $sql);
                    while ($arr = mysqli_fetch_array($rst)) {
                    ?>

                        <tr>
                            <!-- <td> <?php echo $arr["mon_id"] ?> </td> -->
                            <td> <img src="../images_mon/<?php echo $arr["img"]?>" width="50"> </td>
                            <td> <img src="../images_mon/pic_m/<?php echo $arr["img"]?>" width="50"> </td>
                            <td nowrap> <?php echo $arr["name"] ?> </td>
                            <td nowrap> <?php echo $arr["jp_name"] ?> </td>
                            <td> <?php echo ucfirst($arr["type1"]) ?> </td>
                            <td> <?php echo ucfirst($arr["type2"]) ?> </td>
                            <td> <?php echo $arr["base_egg_steps"] ?> </td>
                            <td> <?php echo $arr["capture_rate"] ?> </td>
                            <td> <?php echo $arr["exp_growth"] ?> </td>
                            <td> <?php echo $arr["hp"] ?> </td>
                            <td> <?php echo $arr["attack"] ?> </td>
                            <td> <?php echo $arr["defense"] ?> </td>
                            <td> <?php echo $arr["sp_attack"] ?> </td>
                            <td> <?php echo $arr["sp_defense"] ?> </td>
                            <td> <?php echo $arr["speed"] ?> </td>
                            <td> <?php echo $arr["base_total"] ?> </td>
                            <td> <?php echo $arr["LGPE"] ?> </td>
                            <td> <?php echo $arr["SWSH"] ?> </td>
                            <td> <?php echo $arr["BDSP"] ?> </td>
                            <td> <?php echo $arr["PLA"] ?> </td>
                            <td> <?php echo $arr["SV"] ?> </td>
                            <td> <a href="?page=monsters_update&id=<?php echo $arr["mon_id"] ?>" title="Update data"><i class="fa-solid fa-pen"></i></a> </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>

            </div>
            <!--End Table -->

        </div>

    </div>
</div>