<?php
session_start();
include("inc_connect.php");

function showbarcolor($num) {
    
    if ($num >= 130) {
        echo "background-color:#46a152;";
    } elseif ($num >= 100) {
        echo "background-color:#7aec7a;";
    } elseif ($num >= 60) {
        echo "background-color:#fffd6e ;";
    } elseif ($num >= 30) {
        echo "background-color:#e7ae45 ;";
    } elseif ($num < 30) {
        echo "background-color:#ec7979 ;";
    }
    
}

$id = $_GET['id'];
$sql = " Select * From mon_data Where mon_id = '$id' ";
$rst = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($rst);

$hp = $arr['hp'];
$attack     = $arr['attack'];
$defense    = $arr['defense'];
$sp_attack  = $arr['sp_attack'];
$sp_defense = $arr['sp_defense'];
$speed      = $arr['speed'];

?>

<h4 class="text-center fw-bold"><?php echo $arr['name']; ?></h4>
<div>
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-12 border">
            <div>
                <img src="images_mon/pic_m/<?php echo $arr['img']; ?>" class="img-fluid">
            </div>
        </div>
        <div class="col-xl-4 col-lg-8 col-md-12 border">
            <div>
                <h5 class="fw-bold mt-3">Data</h5>
                <div class="row">
                    <div class="col-xl-5 col-md-4 col-3">National No:</div>
                    <div class="col-xl-7 col-md-8 col-9"><?php echo $arr['dex_no']; ?></div>
                    <div class="col-xl-5 col-md-4 col-3">JP Name:</div>
                    <div class="col-xl-7 col-md-8 col-9"><?php echo $arr['jp_name']; ?></div>
                    <div class="col-xl-5 col-md-4 col-3">Type:</div>
                    <div class="col-xl-7 col-md-8 col-9">
                        <img src="images/type_icon/<?php echo $arr['type1'] ?>.png" title="<?php echo ucfirst($arr['type1']) ?>">
                        <?php if ($arr['type2'] != "") { ?>
                            <img src="images/type_icon/<?php echo $arr['type2'] ?>.png" title="<?php echo ucfirst($arr['type2']) ?>">
                        <?php } ?>
                    </div>
                    <div class="col-xl-5 col-md-4 col-3">Egg steps:</div>
                    <div class="col-xl-7 col-md-8 col-9"><?php echo $arr['base_egg_steps'];
                                                            echo " steps"; ?></div>
                    <div class="col-xl-5 col-md-4 col-3">Catch rate:</div>
                    <div class="col-xl-7 col-md-8 col-9"><?php echo $arr['capture_rate']; ?></div>
                    <div class="col-xl-5 col-md-4 col-3">Exp growth:</div>
                    <div class="col-xl-7 col-md-8 col-9"><?php echo $arr['exp_growth']; ?></div>
                </div>
            </div>
        </div>
        <div class="d-xl-none  col-lg-4 col-md-12 border">
        </div>
        <div class="col-xl-5 col-lg-8 col-md-12 border">
            <div>
                <h5 class="fw-bold mt-3">Base Stats:</h5>
                <div class="row">
                    <div class="col-md-4 col-3">HP:</div>
                    <div class="col-md-8 col-9">
                        <div class="block1"><?php echo $hp; ?></div>
                        <div class="bar1" style="<?php showbarcolor($hp); ?>width:<?php echo $hp; ?>px;">&nbsp;</div>
                    </div>
                    <div class="col-md-4 col-3">Attack:</div>
                    <div class="col-md-8 col-9">
                        <div class="block1"><?php echo $attack; ?></div>
                        <div class="bar1" style="<?php showbarcolor($attack); ?>width:<?php echo $attack; ?>px;">&nbsp;</div>
                    </div>
                    <div class="col-md-4 col-3">Defense:</div>
                    <div class="col-md-8 col-9">
                        <div class="block1"><?php echo $defense; ?></div>
                        <div class="bar1" style="<?php showbarcolor($defense); ?>width:<?php echo $defense; ?>px;">&nbsp;</div>
                    </div>
                    <div class="col-md-4 col-3">Sp. Atk:</div>
                    <div class="col-md-8 col-9">
                        <div class="block1"><?php echo $sp_attack; ?></div>
                        <div class="bar1" style="<?php showbarcolor($sp_attack); ?>width:<?php echo $sp_attack; ?>px;">&nbsp;</div>
                    </div>
                    <div class="col-md-4 col-3">Sp. Def:</div>
                    <div class="col-md-8 col-9">
                        <div class="block1"><?php echo $sp_defense; ?></div>
                        <div class="bar1" style="<?php showbarcolor($sp_defense); ?>width:<?php echo $sp_defense; ?>px;">&nbsp;</div>
                    </div>
                    <div class="col-md-4 col-3">Speed:</div>
                    <div class="col-md-8 col-9">
                        <div class="block1"><?php echo $speed; ?></div>
                        <div class="bar1" style="<?php showbarcolor($speed); ?>width:<?php echo $speed; ?>px;">&nbsp;</div>
                    </div>
                    <div class="col-md-4 col-3">Total:</div>
                    <div class="col-md-8 col-9">
                        <div class="float-start"><?php echo $arr['base_total']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php mysqli_close($conn); ?>