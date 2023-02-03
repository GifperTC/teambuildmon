<title> Monsters </title>

<div class="row">
    <div class="col-12">

        <div class="bg-white rounded border my-4 p-3">

            <h3 class="pt-2 pb-3"> <i class="fa fa-list text-danger"></i> Monsters list</h3>

            <!-- Search bar -->
            <form action="" method="get">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <input type="hidden" name="page" value="monsters">
                                <input type="text" class="form-control form-control-sm mb-3" name="keyword" id="keyword" value="<?php if( isset($_GET["keyword"]) ) echo $_GET["keyword"] ?>">
                            </div>
                            <div class="col-5">
                                <select class="form-select form-select-sm" name="type" id="type" value="">
                                    <option value="">--All Type--</option>
                                    <?php
                                    $rsttype = mysqli_query($conn, " SELECT DISTINCT(type1) From mon_data Order by type1 Asc");
                                    while ($arrtype = mysqli_fetch_array($rsttype)) {
                                        echo "<option ";
                                        if (isset($_GET["type"]) and ($_GET["type"]) == ucfirst($arrtype[0])) echo "selected";
                                        echo ">".ucfirst($arrtype[0])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-success btn-sm" id=""> Search </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6"></div>
                </div>
            </form>

            <!-- End Search bar -->

            <!--Table -->
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered" style="font-size: 12px;">
                    <tr class="table-danger">
                        <!-- <th>ID</th> -->
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
                        <th>RB</th>
                        <th>GSC</th>
                        <th>RSE</th>
                        <th>FRLG</th>
                        <th>DPP</th>
                        <th>HGSS</th>
                        <th>BW</th>
                        <th>B2W2</th>
                        <th>XY</th>
                        <th>ORAS</th>
                        <th>SM</th>
                        <th>USUM</th>
                        <th>LG</th>
                        <th>SwSh</th>
                        <th>BDSP</th>
                        <th>PLA</th>
                        <th>SV</th>
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
                    if ( isset($_GET['type']) ) {
                        $type = $_GET['type'];

                        // query for word that include the type 
                        $sql .= " And type1 like '%$type%' ";
                    }

                    $sql .= " Order By Name Asc";

                    $rst = mysqli_query($conn, $sql);
                    while ($arr = mysqli_fetch_array($rst)) {
                    ?>

                        <tr>
                            <!-- <td> <?php echo $arr["mon_id"] ?> </td> -->
                            <td> <img src="../images_mon/<?php echo $arr["img"] ?>" width="30"> </td>
                            <td nowrap> <?php echo $arr["name"] ?> </td>
                            <td nowrap> <?php echo $arr["japanese_name"] ?> </td>
                            <td> <?php echo ucfirst($arr["type1"]) ?> </td>
                            <td> <?php echo ucfirst($arr["type2"]) ?> </td>
                            <td> <?php echo $arr["base_egg_steps"] ?> </td>
                            <td> <?php echo $arr["capture_rate"] ?> </td>
                            <td> <?php echo $arr["experience_growth"] ?> </td>
                            <td> <?php echo $arr["hp"] ?> </td>
                            <td> <?php echo $arr["attack"] ?> </td>
                            <td> <?php echo $arr["defense"] ?> </td>
                            <td> <?php echo $arr["sp_attack"] ?> </td>
                            <td> <?php echo $arr["sp_defense"] ?> </td>
                            <td> <?php echo $arr["speed"] ?> </td>
                            <td> <?php echo $arr["RB"] ?> </td>
                            <td> <?php echo $arr["GSC"] ?> </td>
                            <td> <?php echo $arr["RSE"] ?> </td>
                            <td> <?php echo $arr["FRLG"] ?> </td>
                            <td> <?php echo $arr["DPP"] ?> </td>
                            <td> <?php echo $arr["HGSS"] ?> </td>
                            <td> <?php echo $arr["BW"] ?> </td>
                            <td> <?php echo $arr["B2W2"] ?> </td>
                            <td> <?php echo $arr["XY"] ?> </td>
                            <td> <?php echo $arr["ORAS"] ?> </td>
                            <td> <?php echo $arr["SM"] ?> </td>
                            <td> <?php echo $arr["USUM"] ?> </td>
                            <td> <?php echo $arr["LG"] ?> </td>
                            <td> <?php echo $arr["SwSh"] ?> </td>
                            <td> <?php echo $arr["BDSP"] ?> </td>
                            <td> <?php echo $arr["PLA"] ?> </td>
                            <td> <?php echo $arr["SV"] ?> </td>
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