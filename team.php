<?php
function ResetSession() {
    unset($_SESSION['mon_id']);
    unset($_SESSION['name']);
    unset($_SESSION['jp_name']);
    unset($_SESSION['img']);
    unset($_SESSION['type1']);
    unset($_SESSION['type2']);
    unset($_SESSION['base_egg_steps']);
    unset($_SESSION['capture_rate']);
    unset($_SESSION['exp_growth']);
    unset($_SESSION['hp']);
    unset($_SESSION['attack']);
    unset($_SESSION['defense']);
    unset($_SESSION['sp_attack']);
    unset($_SESSION['sp_defense']);
    unset($_SESSION['speed']);
}

function CreateSession() {
    $_SESSION['mon_id'] = array();
    $_SESSION['name'] = array();
    $_SESSION['jp_name'] = array();
    $_SESSION['img'] = array();
    $_SESSION['type1'] = array();
    $_SESSION['type2'] = array();
    $_SESSION['base_egg_steps'] = array();
    $_SESSION['capture_rate'] = array();
    $_SESSION['exp_growth'] = array();
    $_SESSION['hp'] = array();
    $_SESSION['attack'] = array();
    $_SESSION['defense'] = array();
    $_SESSION['sp_attack'] = array();
    $_SESSION['sp_defense'] = array();
    $_SESSION['speed'] = array();
}

function GetMonster($mon_id) {
    global $conn;
    $sqlm = " Select * From mon_data Where mon_id = '$mon_id' ";
    $rstm = mysqli_query($conn, $sqlm);
    $arrm = mysqli_fetch_array($rstm);
    array_push($_SESSION['mon_id'],$arrm['mon_id']); 
    array_push($_SESSION['name'],$arrm['name']); 
    array_push($_SESSION['jp_name'],$arrm['jp_name']); 
    array_push($_SESSION['img'],$arrm['img']); 
    array_push($_SESSION['type1'],$arrm['type1']); 
    array_push($_SESSION['type2'],$arrm['type2']); 
    array_push($_SESSION['base_egg_steps'],$arrm['base_egg_steps']); 
    array_push($_SESSION['capture_rate'],$arrm['capture_rate']); 
    array_push($_SESSION['exp_growth'],$arrm['exp_growth']); 
    
    array_push($_SESSION['hp'],$arrm['hp']); 
    array_push($_SESSION['attack'],$arrm['attack']); 
    array_push($_SESSION['defense'],$arrm['defense']); 
    array_push($_SESSION['sp_attack'],$arrm['sp_attack']); 
    array_push($_SESSION['sp_defense'],$arrm['sp_defense']); 
    array_push($_SESSION['speed'],$arrm['speed']); 
}

function showbarcolor($num) {
    if ($num >= 100) {
        echo "background-color:#168224;";
    } elseif ($num >= 90) {
        echo "background-color:#7aec7a;";
    } elseif ($num >= 60) {
        echo "background-color:#e4dd61 ;";
    } elseif ($num >= 30) {
        echo "background-color:#e7ae45 ;";
    } elseif ($num < 30) {
        echo "background-color:#ec7979 ;";
    }
}

if ( !isset($_SESSION['game_id'])) { $_SESSION['game_id'] = 0; }

if ( !isset($_SESSION['mon_id'])) {
    CreateSession();
}

//Save team
if ( isset($_GET['type']) And trim($_GET['type']) == "save" And isset($_SESSION['login_id']) ) {

    $mem_id = $_SESSION['login_id'];
    $game_short = $_SESSION['game_id'];
    $mon_id1 = isset($_SESSION['mon_id'][0]) ? $_SESSION['mon_id'][0] : 0;
    $mon_id2 = isset($_SESSION['mon_id'][1]) ? $_SESSION['mon_id'][1] : 0;
    $mon_id3 = isset($_SESSION['mon_id'][2]) ? $_SESSION['mon_id'][2] : 0;
    $mon_id4 = isset($_SESSION['mon_id'][3]) ? $_SESSION['mon_id'][3] : 0;
    $mon_id5 = isset($_SESSION['mon_id'][4]) ? $_SESSION['mon_id'][4] : 0;
    $mon_id6 = isset($_SESSION['mon_id'][5]) ? $_SESSION['mon_id'][5] : 0;

    $sql = "Delete From team Where mem_id = '$mem_id' And game_short = '$game_short' ";
    mysqli_query($conn, $sql);

    $sql = "Insert Into team ( mem_id, game_short, mon_id1, mon_id2, mon_id3, mon_id4, mon_id5, mon_id6 ) 
            values ( '$mem_id', '$game_short', '$mon_id1', '$mon_id2', '$mon_id3', '$mon_id4', '$mon_id5', '$mon_id6' )";
    mysqli_query($conn, $sql);
    echo "<script> alert('Save Team Completed.'); </script>";
    echo "<script> window.location='index.php?page=team'; </script>";
    exit();
}

//Load team
if ( isset($_GET['type']) And trim($_GET['type']) == "load" And isset($_SESSION['login_id']) ) {

    ResetSession();
    CreateSession();
    $sqlg = " Select * From team Where mem_id='".$_SESSION['login_id']."' And game_short = '".$_SESSION['game_id']."'"; 
    $rstg = mysqli_query($conn, $sqlg);
    $arrg = mysqli_fetch_array($rstg);
    if ( isset($arrg['team_id']) ) {
        if ( $arrg['mon_id1'] != 0) GetMonster($arrg['mon_id1']);
        if ( $arrg['mon_id2'] != 0) GetMonster($arrg['mon_id2']);
        if ( $arrg['mon_id3'] != 0) GetMonster($arrg['mon_id3']);
        if ( $arrg['mon_id4'] != 0) GetMonster($arrg['mon_id4']);
        if ( $arrg['mon_id5'] != 0) GetMonster($arrg['mon_id5']);
        if ( $arrg['mon_id6'] != 0) GetMonster($arrg['mon_id6']);
    } else {
        echo "<script> alert('No Data'); </script>";
    }

}

//Reset team
if ( isset($_GET['type']) And trim($_GET['type']) == "reset" And isset($_SESSION['login_id']) ) {
    ResetSession();
    CreateSession();
}

//Select Game
if ( isset($_GET['g']) And trim($_GET['g']) != "" ) {
    $_SESSION['game_id'] = $_GET['g'];
    if ($_SESSION['game_id'] != 0) {
        $rstg = mysqli_query($conn, " Select * From game Where game_short = '".$_SESSION['game_id']."'");
        $arrg = mysqli_fetch_array($rstg);
        $_SESSION['game_name'] = $arrg['game_name'];
    }
    ResetSession();
    echo "<script> window.location='index.php?page=team'; </script>";
    exit();
}

//ลบ Monster
if ( isset($_GET['type']) And trim($_GET['type']) == "remove" and isset($_GET['mon_id']) And trim($_GET['mon_id']) != "" ) {
    if (($key = array_search($_GET['mon_id'], $_SESSION['mon_id'])) !== false) {
        unset($_SESSION['mon_id'][$key]);
        unset($_SESSION['name'][$key]);
        unset($_SESSION['jp_name'][$key]);
        unset($_SESSION['img'][$key]);
        unset($_SESSION['type1'][$key]);
        unset($_SESSION['type2'][$key]);
        unset($_SESSION['base_egg_steps'][$key]);
        unset($_SESSION['capture_rate'][$key]);
        unset($_SESSION['exp_growth'][$key]);
        unset($_SESSION['hp'][$key]);
        unset($_SESSION['attack'][$key]);
        unset($_SESSION['defense'][$key]);
        unset($_SESSION['sp_attack'][$key]);
        unset($_SESSION['sp_defense'][$key]);
        unset($_SESSION['speed'][$key]);
        $_SESSION['mon_id']         = array_values($_SESSION['mon_id']);  //เรียงลำดับใหม่ เริ่มต้นจาก index 0
        $_SESSION['name']           = array_values($_SESSION['name']);
        $_SESSION['jp_name']  = array_values($_SESSION['jp_name']);
        $_SESSION['img']            = array_values($_SESSION['img']);
        $_SESSION['type1']          = array_values($_SESSION['type1']);
        $_SESSION['type2']          = array_values($_SESSION['type2']);
        $_SESSION['base_egg_steps'] = array_values($_SESSION['base_egg_steps']);
        $_SESSION['capture_rate']   = array_values($_SESSION['capture_rate']);
        $_SESSION['exp_growth']  = array_values($_SESSION['exp_growth']);
        $_SESSION['hp']             = array_values($_SESSION['hp']);
        $_SESSION['attack']         = array_values($_SESSION['attack']);
        $_SESSION['defense']        = array_values($_SESSION['defense']);
        $_SESSION['sp_attack']      = array_values($_SESSION['sp_attack']);
        $_SESSION['sp_defense']     = array_values($_SESSION['sp_defense']);
        $_SESSION['speed']          = array_values($_SESSION['speed']);
        echo "<script> window.location='index.php?page=team'; </script>";
        exit();
    }
}

//เลือก Monster เพิ่ม
if ( isset($_GET['mon_id']) And trim($_GET['mon_id']) != "" ) {
    if (in_array($_GET['mon_id'],$_SESSION['mon_id']) ) {
        echo "<script> alert('You already pick this pokemon!');</script>";
    } else {
        GetMonster($_GET['mon_id']);
    }
    echo "<script> window.location='index.php?page=team'; </script>";
    exit();
}

$num_mon = count($_SESSION['mon_id']);  //นับจำนวน Monster

$img1 = isset($_SESSION['img'][0]) ? "images_mon/".$_SESSION['img'][0] : "images/slot.png";
$img2 = isset($_SESSION['img'][1]) ? "images_mon/".$_SESSION['img'][1] : "images/slot.png";
$img3 = isset($_SESSION['img'][2]) ? "images_mon/".$_SESSION['img'][2] : "images/slot.png";
$img4 = isset($_SESSION['img'][3]) ? "images_mon/".$_SESSION['img'][3] : "images/slot.png";
$img5 = isset($_SESSION['img'][4]) ? "images_mon/".$_SESSION['img'][4] : "images/slot.png";
$img6 = isset($_SESSION['img'][5]) ? "images_mon/".$_SESSION['img'][5] : "images/slot.png";
$imglink1 = isset($_SESSION['img'][0]) ? '#ModalData" class="showdata" data-id="'.$_SESSION['mon_id'][0] : "#ModalList";
$imglink2 = isset($_SESSION['img'][1]) ? '#ModalData" class="showdata" data-id="'.$_SESSION['mon_id'][1] : "#ModalList";
$imglink3 = isset($_SESSION['img'][2]) ? '#ModalData" class="showdata" data-id="'.$_SESSION['mon_id'][2] : "#ModalList";
$imglink4 = isset($_SESSION['img'][3]) ? '#ModalData" class="showdata" data-id="'.$_SESSION['mon_id'][3] : "#ModalList";
$imglink5 = isset($_SESSION['img'][4]) ? '#ModalData" class="showdata" data-id="'.$_SESSION['mon_id'][4] : "#ModalList";
$imglink6 = isset($_SESSION['img'][5]) ? '#ModalData" class="showdata" data-id="'.$_SESSION['mon_id'][5] : "#ModalList";
?>

    <title> Team Planner </title>

    <h3 class="text-center pt-4 pb-3">Team Planner</h3>

    <h4 class="text-primary fw-bold ms-2"> Game: </h4>
    <a href="?page=team&g=0" class="ms-4 small" title="Select game">[change]</a>

    <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6">
        </div>
        <?php
        $sqlg = " Select * From game ";
        if ($_SESSION['game_id'] != 0) $sqlg .= " Where game_short = '".$_SESSION['game_id']."'";
        $sqlg .= " Order By game_id Asc";
        $rstg = mysqli_query($conn, $sqlg);
        while ($arrg = mysqli_fetch_array($rstg)) 
        {
            ?>
            <div class="col-lg-2 col-md-4 col-sm-6  d-flex">
                <div class="p-3 text-center align-items-center">
                    <a href="?page=team&g=<?php echo $arrg['game_short']?>"><img src="images/<?php echo $arrg['game_img']?>" class="img-fluid" title="<?php echo $arrg['game_name']?>"></a>
                    <?php if ($_SESSION['game_id'] != 0 and $_SESSION['game_name']==$arrg['game_name']) echo "<div class='small pt-3 fw-bold'>".$_SESSION['game_name']."</div>";?>
                </div>
            </div>
            <?php 
        }
        ?>
    </div>
    
    <p class="my-4">&nbsp;</p>

    <?php if ( $_SESSION['game_id'] != 0 )   //ต้องเลือกเกมส์ก่อนจึงจะแสดง
    {
        ?>

        <!-- Add pokemon modal start-->
        <div class="modal fade" id="ModalList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">List</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php
                        $sql = " Select * From mon_data Where ".$_SESSION['game_id']." = 'Y' Order By mon_id Asc ";
                        $rst = mysqli_query($conn, $sql);
                        while ($arr = mysqli_fetch_array($rst))
                        {
                            ?>
                            <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                                <a data-bs-toggle="modal" data-id="<?php echo $arr['mon_id'];?>" class="monster" data-bs-target="#ModalDetail"><img src="images_mon/<?php echo $arr['img'];?>" class="slot img-fluid rounded-circle"></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        <!-- Add pokemon modal end-->

        <!-- Individual pokemon modal start-->
        <div class="modal fade" id="ModalDetail" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Select Pokemon to your team</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="showid" class="d-none"></div>
                    <div id="showmon"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#ModalList"> Back </button>
                    <button type="button" id="btnAddMon" class="btn btn-primary"> Add Pokemon </button>
                </div>
                </div>
            </div>
        </div>
        <!-- Individual pokemon modal end-->

        <!-- Show pokemon modal start-->
        <div class="modal fade" id="ModalData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Your Pokemon</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="detailid" class="d-none"></div>
                    <div id="detailmon"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btnRemoveMon" class="btn btn-outline-danger"> Remove Pokemon </button>
                </div>
                </div>
            </div>
        </div>
        <!-- Show pokemon modal end-->

        <!-- Save Team modal start-->
        <div class="modal fade" id="ModalSave" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Save this team</h3>
                    </div>
                    <div class="modal-body">
                        <?php
                        if ( !isset($_SESSION['login_username']) ) {
                            echo "<h5> Please login first ! </h5>";
                        } elseif ($num_mon == 0) {
                            echo "<h5> Select at least 1 pokemon ! </h5>";
                        } else {
                            echo "<h5> Save Team to <br> <b>".$_SESSION['game_name']."</b> ? </h5>";
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <?php 
                        if ( !isset($_SESSION['login_username']) ) { 
                            echo "<button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#ModalLogin'>Login</button> &nbsp;";
                        } elseif ($num_mon == 0) { 
                            echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>';
                        } else { ?>
                            <button type="button" id="btnSave" class="btn btn-success"> OK </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <?php 
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Save Team modal end-->

        <!-- Load Team modal start-->
        <div class="modal fade" id="ModalLoad" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Load team</h3>
                </div>
                <div class="modal-body">
                    <?php
                    if ( isset($_SESSION['login_username']) ) {
                        echo "<h5> Load Team of <br> <b>".$_SESSION['game_name']."</b> ? </h5>";
                    } else {
                        echo "<h5> Please login first ! </h5>";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <?php if ( isset($_SESSION['login_username']) ) { ?>
                        <button type="button" id="btnLoad" class="btn btn-success"> OK </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <?php  } else { 
                        echo "<button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#ModalLogin'>Login</button> &nbsp;";
                      }  ?>
                </div>
                </div>
            </div>
        </div>
        <!-- Load Team modal end-->


        <h4 class="text-primary fw-bold ms-2"> Your Pokemon Team: </h4>

        <?php  //if ($num_mon == 0) { echo "<h3 class='text-center'>ยังไม่มีรายการ</h3>"; } ?>

        <div class="table-responsive">
            <table class="table table-sm table-hover table-bordered">
                <tr class="text-center align-middle border-white">
                    <td></td>
                    <td width="15%"><a data-bs-toggle="modal" data-bs-target="<?php echo $imglink1; ?>"><img src="<?php echo $img1; ?>" class="slot rounded-circle w-75"></a></td>
                    <td width="15%"><a data-bs-toggle="modal" data-bs-target="<?php echo $imglink2; ?>"><img src="<?php echo $img2; ?>" class="slot rounded-circle w-75"></a></td>
                    <td width="15%"><a data-bs-toggle="modal" data-bs-target="<?php echo $imglink3; ?>"><img src="<?php echo $img3; ?>" class="slot rounded-circle w-75"></a></td>
                    <td width="15%"><a data-bs-toggle="modal" data-bs-target="<?php echo $imglink4; ?>"><img src="<?php echo $img4; ?>" class="slot rounded-circle w-75"></a></td>
                    <td width="15%"><a data-bs-toggle="modal" data-bs-target="<?php echo $imglink5; ?>"><img src="<?php echo $img5; ?>" class="slot rounded-circle w-75"></a></td>
                    <td width="15%"><a data-bs-toggle="modal" data-bs-target="<?php echo $imglink6; ?>"><img src="<?php echo $img6; ?>" class="slot rounded-circle w-75"></a></td>
                </tr>
                <tr class="text-center align-middle fw-bold border-top-1">
                    <td> </td>
                    <td> <?php echo isset($_SESSION['name'][0]) ? $_SESSION['name'][0] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['name'][1]) ? $_SESSION['name'][1] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['name'][2]) ? $_SESSION['name'][2] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['name'][3]) ? $_SESSION['name'][3] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['name'][4]) ? $_SESSION['name'][4] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['name'][5]) ? $_SESSION['name'][5] : "-"; ?> </td>
                </tr>
                <tr class="text-center align-middle small">
                    <td class="fw-bold"> JP Name </td>
                    <td> <?php echo isset($_SESSION['jp_name'][0]) ? $_SESSION['jp_name'][0] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['jp_name'][1]) ? $_SESSION['jp_name'][1] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['jp_name'][2]) ? $_SESSION['jp_name'][2] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['jp_name'][3]) ? $_SESSION['jp_name'][3] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['jp_name'][4]) ? $_SESSION['jp_name'][4] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['jp_name'][5]) ? $_SESSION['jp_name'][5] : "-"; ?> </td>
                </tr>
                <tr class="text-center align-middle small">
                    <td class="fw-bold"> Type 1 </td>
                    <td> <?php echo isset($_SESSION['type1'][0]) && $_SESSION['type1'][0]!="" ? "<img src='images/type_icon/".$_SESSION['type1'][0].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type1'][1]) && $_SESSION['type1'][1]!="" ? "<img src='images/type_icon/".$_SESSION['type1'][1].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type1'][2]) && $_SESSION['type1'][2]!="" ? "<img src='images/type_icon/".$_SESSION['type1'][2].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type1'][3]) && $_SESSION['type1'][3]!="" ? "<img src='images/type_icon/".$_SESSION['type1'][3].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type1'][4]) && $_SESSION['type1'][4]!="" ? "<img src='images/type_icon/".$_SESSION['type1'][4].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type1'][5]) && $_SESSION['type1'][5]!="" ? "<img src='images/type_icon/".$_SESSION['type1'][5].".png'>" : "-"; ?> </td>
         
                </tr>
                <tr class="text-center align-middle small">
                    <td class="fw-bold"> Type 2 </td>
                    <td> <?php echo isset($_SESSION['type2'][0]) && $_SESSION['type2'][0]!="" ? "<img src='images/type_icon/".$_SESSION['type2'][0].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type2'][1]) && $_SESSION['type2'][1]!="" ? "<img src='images/type_icon/".$_SESSION['type2'][1].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type2'][2]) && $_SESSION['type2'][2]!="" ? "<img src='images/type_icon/".$_SESSION['type2'][2].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type2'][3]) && $_SESSION['type2'][3]!="" ? "<img src='images/type_icon/".$_SESSION['type2'][3].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type2'][4]) && $_SESSION['type2'][4]!="" ? "<img src='images/type_icon/".$_SESSION['type2'][4].".png'>" : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['type2'][5]) && $_SESSION['type2'][5]!="" ? "<img src='images/type_icon/".$_SESSION['type2'][5].".png'>" : "-"; ?> </td>
                </tr>
                <tr class="text-center align-middle small">
                    <td class="fw-bold"> Egg steps </td>
                    <td> <?php echo isset($_SESSION['base_egg_steps'][0]) ? $_SESSION['base_egg_steps'][0] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['base_egg_steps'][1]) ? $_SESSION['base_egg_steps'][1] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['base_egg_steps'][2]) ? $_SESSION['base_egg_steps'][2] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['base_egg_steps'][3]) ? $_SESSION['base_egg_steps'][3] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['base_egg_steps'][4]) ? $_SESSION['base_egg_steps'][4] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['base_egg_steps'][5]) ? $_SESSION['base_egg_steps'][5] : "-"; ?> </td>
                </tr>
                <tr class="text-center align-middle small">
                    <td class="fw-bold"> Catch rate </td>
                    <td> <?php echo isset($_SESSION['capture_rate'][0]) ? $_SESSION['capture_rate'][0] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['capture_rate'][1]) ? $_SESSION['capture_rate'][1] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['capture_rate'][2]) ? $_SESSION['capture_rate'][2] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['capture_rate'][3]) ? $_SESSION['capture_rate'][3] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['capture_rate'][4]) ? $_SESSION['capture_rate'][4] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['capture_rate'][5]) ? $_SESSION['capture_rate'][5] : "-"; ?> </td>
                </tr>
                <tr class="text-center align-middle small">
                    <td class="fw-bold"> Exp growth </td>
                    <td> <?php echo isset($_SESSION['exp_growth'][0]) ? $_SESSION['exp_growth'][0] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['exp_growth'][1]) ? $_SESSION['exp_growth'][1] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['exp_growth'][2]) ? $_SESSION['exp_growth'][2] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['exp_growth'][3]) ? $_SESSION['exp_growth'][3] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['exp_growth'][4]) ? $_SESSION['exp_growth'][4] : "-"; ?> </td>
                    <td> <?php echo isset($_SESSION['exp_growth'][5]) ? $_SESSION['exp_growth'][5] : "-"; ?> </td>
                </tr>
            </table>
        </div>

        <div class="text-end mb-4">
            <button class="btn btn-secondary btn-sm" id="btnReset"> Reset Team </button>
            <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalLoad">
            <i class="fa-solid fa-upload"></i> &nbsp; Load Team     
            </a>
            <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ModalSave">
                <i class="fa-solid fa-floppy-disk"></i> &nbsp; Save Team     
            </a>
        </div>



        <!-- "Best Stats" start-->
        <!-- <?php if ($num_mon >= 2) { ?>

            <h4 class="text-primary fw-bold ms-2 mt-4"> Best Stats: </h4>

            <div class="w-50 mx-auto p-2 my-2" >
                <select name="" id="" class="form-select">
                    <option value="HP"> HP </option>
                    <option value="HP"> HP </option>
                    <option value="HP"> HP </option>
                    <option value="HP"> HP </option>
                    <option value="HP"> HP </option>
                </select>
            </div>

            <div class="border rounded w-50 mx-auto p-2 mt-2 mb-5"style="box-shadow:3px 3px 3px #999999;">
                <div class="row">
                    <div class="col-md-3 d-flex" style="justify-content:center;align-items:center;">
                        <h4 class="fw-bold text-primary">HP</h4> 
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-2 d-flex" style="justify-content:center;align-items:center;"><img src="images_mon/pic_m/1.png" class="img-fluid w-50 me-2"></div>
                            <div class="col-2 d-flex" style="align-items:center;">150</div>
                            <div class="col-8 d-flex" style="align-items:center;"><div class="bar1" style="<?php showbarcolor(120);?>width:120px;">&nbsp;</div></div>
                            <div class="col-2 d-flex" style="justify-content:center;align-items:center;"><img src="images_mon/pic_m/2.png" class="img-fluid w-50 me-2"></div>
                            <div class="col-2 d-flex" style="align-items:center;">150</div>
                            <div class="col-8 d-flex" style="align-items:center;"><div class="bar1" style="<?php showbarcolor(120);?>width:110px;">&nbsp;</div></div>
                            <div class="col-2 d-flex" style="justify-content:center;align-items:center;"><img src="images_mon/pic_m/4.png" class="img-fluid w-50 me-2"></div>
                            <div class="col-2 d-flex" style="align-items:center;">150</div>
                            <div class="col-8 d-flex" style="align-items:center;"><div class="bar1" style="<?php showbarcolor(120);?>width:90px;">&nbsp;</div></div>
                            <div class="col-2 d-flex" style="justify-content:center;align-items:center;"><img src="images_mon/pic_m/5.png" class="img-fluid w-50 me-2"></div>
                            <div class="col-2 d-flex" style="align-items:center;">150</div>
                            <div class="col-8 d-flex" style="align-items:center;"><div class="bar1" style="<?php showbarcolor(120);?>width:60px;">&nbsp;</div></div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?> -->
        <!-- "Best Stats" end -->


        <!-- Team Stats -->
        <h4 class="text-primary fw-bold ms-2 mt-4"> Team Stats: </h4>

        <div class="m-2 px-2 pt-1 pb-3">
            <div class="row">
            <?php
                for ( $i = 0; $i < 6; $i++ ) 
                {
                    if (isset($_SESSION['mon_id'][$i]) and $_SESSION['mon_id'][$i] != 0) 
                    {
                        $mon_id = $_SESSION['mon_id'][$i];
                        $sql = " Select * From mon_data Where mon_id = '$mon_id' ";     
                        $rst = mysqli_query($conn, $sql);
                        $arr = mysqli_fetch_array($rst);
                        $hp = $arr['hp'];
                        $attack     = $arr['attack'];
                        $defense    = $arr['defense'];
                        $sp_attack  = $arr['sp_attack'];
                        $sp_defense = $arr['sp_defense'];
                        $speed      = $arr['speed'];
                        ?>
                        <div class="col-lg-6">
                            <div class="border rounded mt-3" style="box-shadow:3px 3px 3px #999999;">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="images_mon/pic_m/<?php echo $arr['img']; ?>" class="img-fluid m-2">
                                        <div class="text-center my-2 small fw-bold"><?php echo $arr['name']; ?></div>
                                    </div>
                                    <div class="col-8">
                                        <h6 class="fw-bold mt-3">Base Stats:</h6>
                                        <div class="row">
                                            <div class="col-md-3 col-3">HP:</div>
                                            <div class="col-md-9 col-9 small">
                                                <div class="block1"><?php echo $arr['hp']; ?></div>
                                                <div class="bar1" style="<?php showbarcolor($hp);?>width:<?php echo $hp;?>px;">&nbsp;</div>
                                            </div>
                                            <div class="col-md-3 col-3">Attack:</div>
                                            <div class="col-md-9 col-9 small">
                                                <div class="block1"><?php echo $arr['attack']; ?></div>
                                                <div class="bar1" style="<?php showbarcolor($attack);?>width:<?php echo $attack;?>px;">&nbsp;</div>
                                            </div>
                                            <div class="col-md-3 col-3">Defense:</div>
                                            <div class="col-md-9 col-9 small">
                                                <div class="block1"><?php echo $arr['defense']; ?></div>
                                                <div class="bar1" style="<?php showbarcolor($defense);?>width:<?php echo $defense;?>px;">&nbsp;</div>
                                            </div>
                                            <div class="col-md-3 col-3">Sp. Atk:</div>
                                            <div class="col-md-9 col-9 small">
                                                <div class="block1"><?php echo $arr['sp_attack']; ?></div>
                                                <div class="bar1" style="<?php showbarcolor($sp_attack);?>width:<?php echo $sp_attack;?>px;">&nbsp;</div>
                                            </div>
                                            <div class="col-md-3 col-3">Sp. Def:</div>
                                            <div class="col-md-9 col-9 small">
                                                <div class="block1"><?php echo $arr['sp_defense']; ?></div>
                                                <div class="bar1" style="<?php showbarcolor($sp_defense);?>width:<?php echo $sp_defense;?>px;">&nbsp;</div>
                                            </div>
                                            <div class="col-md-3 col-3">Speed:</div>
                                            <div class="col-md-9 col-9 small">
                                                <div class="block1"><?php echo $arr['speed']; ?></div>
                                                <div class="bar1" style="<?php showbarcolor($speed);?>width:<?php echo $speed;?>px;">&nbsp;</div>
                                            </div>
                                            <div class="col-md-3 col-3">Total:</div>
                                            <div class="col-md-9 col-9 small">
                                                <div class="float-start"><?php echo $arr['base_total']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>


        <!-- Stats comparison graph -->
        <h4 class="text-primary fw-bold ms-2 mt-4"> Stats Comparison: </h4>

        <div class="m-2">
            <div class="row">
                <div class="col-12">
                    <div id="columnchart_stat" class="mx-auto" style="width:80%;height:500px;"></div>
                </div>
            </div>
        </div>

        <?php  
    }
    ?>

<style>
    .slot:hover {
        transform: scale(1.2);
        transition: transform .5s;
        cursor: pointer;
    }
</style>

<?php 
if ($num_mon != 0) {
?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Stats', <?php for( $i=0; $i<$num_mon; $i++) { echo "'".$_SESSION['name'][$i]."',"; } ?> {role: 'style'}],
            ['HP', <?php for( $i=0; $i<$num_mon; $i++) { echo "".$_SESSION['hp'][$i].","; } ?> 'red'],
            ['ATK', <?php for( $i=0; $i<$num_mon; $i++) { echo "".$_SESSION['attack'][$i].","; } ?> 'green'],
            ['DEF', <?php for( $i=0; $i<$num_mon; $i++) { echo "".$_SESSION['defense'][$i].","; } ?> 'blue'],
            ['SA', <?php for( $i=0; $i<$num_mon; $i++) { echo "".$_SESSION['sp_attack'][$i].","; } ?> 'pink'],
            ['SD', <?php for( $i=0; $i<$num_mon; $i++) { echo "".$_SESSION['sp_defense'][$i].","; } ?> 'yellow'],
            ['SPD', <?php for( $i=0; $i<$num_mon; $i++) { echo "".$_SESSION['speed'][$i].","; } ?> 'black'],
        ]);     
        var options = {
            legend: { position: 'bottom' },
            chart: {
                // title: 'Monsters Comparison',
                // subtitle: '...',
            }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_stat'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>

<?php } ?>


<script>
$(document).ready(function(){

    $(".monster").click(function(){
        $("#showid").text($(this).data('id'))
        $.get( "ajax_getmon.php",{ 
            id: $(this).data('id')
            }, function(data, status) {
                $("#showmon").html(data)
            }
        ).fail(function(){
            $("#showmon").html("Can't get file")
        })
    })

    $(".showdata").click(function(){
        $("#detailid").text($(this).data('id'))
        $.get( "ajax_getmon.php",{ 
            id: $(this).data('id')
            }, function(data, status) {
                $("#detailmon").html(data)
            }
        ).fail(function(){
            $("#detailmon").html("Can't get file")
        })
    })

    $("#btnRemoveMon").click(function(){
        var mid = $("#detailid").text()
        window.location='index.php?page=team&type=remove&mon_id='+mid
    })

    $("#btnSave").click(function(){
        window.location='index.php?page=team&type=save'
    })

    $("#btnLoad").click(function(){
        window.location='index.php?page=team&type=load'
    })

    $("#btnReset").click(function(){
        if ( confirm('Reset this team ?') ) {
            window.location='index.php?page=team&type=reset';
        }
    })

})

$(document).on("click", "#btnAddMon", function () {
    var mid = $("#showid").text();
    window.location='index.php?page=team&mon_id='+mid;
});
</script>

