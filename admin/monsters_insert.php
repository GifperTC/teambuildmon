<?php
if ( !isset($_SESSION['login_id']) or $_SESSION['login_role'] != "admin" ) {
    header("refresh:1; url=login.php");
    exit();
}

//บันทึกข้อมูล
if ( isset($_POST['submit']) and isset($_POST['dex_no'])) {

    $dex_no = $_POST['dex_no'];
    $name = $_POST['name'];
    $jp_name = $_POST['jp_name'];
    $img = "noimage.png";
    $img2 = "noimage.png";
    $type1 = $_POST['type1'];
    $type2 = $_POST['type2'];
    $base_egg_steps = $_POST['base_egg_steps'];
    $capture_rate = $_POST['capture_rate'];
    $exp_growth = $_POST['exp_growth'];
    $hp = $_POST['hp'];
    $attack = $_POST['attack'];
    $defense = $_POST['defense'];
    $sp_attack = $_POST['sp_attack'];
    $sp_defense = $_POST['sp_defense'];
    $speed = $_POST['speed'];
    $base_total = $hp + $attack + $defense + $sp_attack + $sp_defense + $speed;
    $LGPE = isset($_POST['LGPE']) ? $_POST['LGPE'] : "No";
    $SWSH = isset($_POST['SWSH']) ? $_POST['SWSH'] : "No";
    $BDSP = isset($_POST['BDSP']) ? $_POST['BDSP'] : "No";
    $PLA = isset($_POST['PLA']) ? $_POST['PLA'] : "No";
    $SV = isset($_POST['SV']) ? $_POST['SV'] : "No";
    $flagimg = "No";
    $flagimg2 = "No";

    if ( isset($_FILES['img']['name']) and $_FILES['img']['name'] != "" ) {   //กรณีใส่รูป
        $fsize = $_FILES['img']['size'];
        $ftype = $_FILES['img']['type'];
        $fdata = $_FILES['img']['tmp_name'];
        if ($ftype != "image/jpeg" and $ftype != "image/png") {
            echo "<script> alert('ไฟล์ jpg หรือ png เท่านั้น'); </script>";
            echo "<script> history.back();</script>";
            exit();
        }
        if ($fsize > 10485760) {  // 10MB = 1024*1024*10
            echo "<script> alert('ขนาดไฟล์ต้องไม่เกิน 10MB '); </script>";
            echo "<script> history.back();</script>";
            exit();
        }
        $flagimg = "Yes";
    }

    if ( isset($_FILES['img2']['name']) and $_FILES['img2']['name'] != "" ) {   //กรณีใส่รูปใหญ่
        $fsize2 = $_FILES['img2']['size'];
        $ftype2 = $_FILES['img2']['type'];
        $fdata2 = $_FILES['img2']['tmp_name'];
        if ($ftype2 != "image/jpeg" and $ftype2 != "image/png") {
            echo "<script> alert('ไฟล์ jpg หรือ png เท่านั้น'); </script>";
            echo "<script> history.back();</script>";
            exit();
        }
        if ($fsize2 > 10485760) {  // 10MB = 1024*1024*10
            echo "<script> alert('ขนาดไฟล์ต้องไม่เกิน 10MB '); </script>";
            echo "<script> history.back();</script>";
            exit();
        }
        $flagimg2 = "Yes";
    }

    $sql = " Insert Into mon_data ( dex_no, name, jp_name, img, type1, type2, base_egg_steps, capture_rate, exp_growth, hp, attack, defense, sp_attack, sp_defense, speed, base_total, LGPE, SWSH, BDSP, PLA, SV) 
             values ( '$dex_no', '$name', '$jp_name', '$img', '$type1', '$type2', '$base_egg_steps', '$capture_rate', '$exp_growth', '$hp', '$attack', '$defense', '$sp_attack', '$sp_defense', '$speed', '$base_total', '$LGPE', '$SWSH', '$BDSP', '$PLA', '$SV')";
    mysqli_query($conn, $sql);

    if ( $flagimg == "Yes" ) {
        $newid = mysqli_insert_id($conn);
        $fext = $ftype == "image/jpeg" ? ".jpg" : ".png";
        move_uploaded_file( $fdata, "../images_mon/".$newid.$fext);
        $img = $newid.$fext;
        mysqli_query($conn, "Update mon_data Set img='$img' Where mon_id = $newid ");
    }
    if ( $flagimg2 == "Yes" ) {
        $fext2 = $ftype2 == "image/jpeg" ? ".jpg" : ".png";
        move_uploaded_file( $fdata2, "../images_mon/pic_m/".$newid.$fext2);
    }

    echo "<script> alert('Save Data Completed.'); </script>";
    echo "<script> window.location='?page=monsters'; </script>";
    mysqli_close($conn);
    exit();

}
?>

<title> Monsters </title>

<form action="" id="frmmon" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-12">

            <div class="bg-white rounded border my-4 p-3">
                <h3 class="pt-2 pb-3"> <i class="fa fa-list text-danger"></i> Insert New Monster</h3>
                <div class="row">
                    <div class="col-lg-2 col-md-2">Dex No.</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="dex_no" id="dex_no" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Image small</div>
                    <div class="col-lg-2 col-md-4"><input type="file" name="img" id="img" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Image big</div>
                    <div class="col-lg-2 col-md-4"><input type="file" name="img2" id="img2" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Name (EN)</div>
                    <div class="col-lg-2 col-md-4"><input type="text" name="name" id="name" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Name (JP)</div>
                    <div class="col-lg-2 col-md-4"><input type="text" name="jp_name" id="jp_name" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Primary type</div>
                    <div class="col-lg-2 col-md-4">
                        <select name="type1" id="type1" class="form-select mt-1 mb-2">
                            <option value="">-- Please Select </option>
                            <?php
                                $sqlt1 = " Select * From type Order by type_name ";
                                $rstt1 = mysqli_query($conn, $sqlt1);
                                while ( $arrt1 = mysqli_fetch_array($rstt1) ) {
                                    echo "<option value='".strtolower($arrt1['type_name'])."'>".$arrt1['type_name']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2">Secondary type</div>
                    <div class="col-lg-2 col-md-4">
                        <select name="type2" id="type2" class="form-select mt-1 mb-2">
                            <option value="0">-- Please Select </option>
                            <option value=""> None </option>
                            <?php
                                $sqlt1 = " Select * From type Order by type_name ";
                                $rstt1 = mysqli_query($conn, $sqlt1);
                                while ( $arrt1 = mysqli_fetch_array($rstt1) ) {
                                    echo "<option value='".strtolower($arrt1['type_name'])."'>".$arrt1['type_name']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2">Base egg steps</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="base_egg_steps" id="base_egg_steps" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Capture rate</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="capture_rate" id="capture_rate" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Exp growth</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="exp_growth" id="exp_growth" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">HP</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="hp" id="hp" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Attack</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="attack" id="attack" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Defense</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="defense" id="defense" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Special Attack</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="sp_attack" id="sp_attack" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Special Defense</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="sp_defense" id="sp_defense" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">Speed</div>
                    <div class="col-lg-2 col-md-4"><input type="number" min="1" name="speed" id="speed" class="form-control mt-1 mb-2"></div>
                    <div class="col-lg-2 col-md-2">LGPE</div>
                    <div class="col-lg-2 col-md-4 mt-2 mb-2">
                        <input type="radio" name="LGPE" id="LGPE1" value="Y" class="form-check-input"> Yes &nbsp;
                        <input type="radio" name="LGPE" id="LGPE2" value="N" class="form-check-input"> No
                    </div>
                    <div class="col-lg-2 col-md-2">SWSH</div>
                    <div class="col-lg-2 col-md-4 mt-2 mb-2">
                        <input type="radio" name="SWSH" id="SWSH1" value="Y" class="form-check-input"> Yes &nbsp;
                        <input type="radio" name="SWSH" id="SWSH2" value="N" class="form-check-input"> No
                    </div>
                    <div class="col-lg-2 col-md-2">BDSP</div>
                    <div class="col-lg-2 col-md-4 mt-2 mb-2">
                        <input type="radio" name="BDSP" id="BDSP1" value="Y" class="form-check-input"> Yes &nbsp;
                        <input type="radio" name="BDSP" id="BDSP2" value="N" class="form-check-input"> No
                    </div>
                    <div class="col-lg-2 col-md-2">PLA</div>
                    <div class="col-lg-2 col-md-4 mt-2 mb-2">
                        <input type="radio" name="PLA" id="PLA1" value="Y" class="form-check-input"> Yes &nbsp;
                        <input type="radio" name="PLA" id="PLA2" value="N" class="form-check-input"> No
                    </div>
                    <div class="col-lg-2 col-md-2">SV</div>
                    <div class="col-lg-2 col-md-4 mt-2 mb-2">
                        <input type="radio" name="SV" id="SV1" value="Y" class="form-check-input"> Yes &nbsp;
                        <input type="radio" name="SV" id="SV2" value="N" class="form-check-input"> No
                    </div>
                </div>
                <div class="my-4">
                    <button name="submit" class="btn btn-primary"> <i class="fa-solid fa-floppy-disk"></i> &nbsp; Save Monster </button>
                    <input type="button" class="btn btn-outline-dark" onclick="window.location='index.php';" value=" Cancel ">
                </div>
            </div>

        </div>
    </div>

</form>

<script>
$(document).ready(function(){
    
    $("#frmmon").submit(function(){  //เมื่อกด Submit
        
        if ($("#dex_no").val() == "") {
            alert('Please Input Dex No.')
            $("#dex_no").focus()
            return false
        }
        if ($("#name").val() == "") {
            alert('Please Input Name (EN)')
            $("#name").focus()
            return false
        }
        if ($("#type1").val() == "") {
            alert('Please Input Primary Type')
            $("#type1").focus()
            return false
        }
        if ($("#type2").val() == "0") {
            alert('Please Input Secondary Type')
            $("#type2").focus()
            return false
        }
        if ( !$("#LGPE1").is(':checked') && !$("#LGPE2").is(':checked') ) {
            alert('Please Select LGPE')
            $("#LGPE1").focus()
            return false
        }
        if ( !$("#SWSH1").is(':checked') && !$("#SWSH2").is(':checked') ) {
            alert('Please Select SWSH')
            $("#SWSH1").focus()
            return false
        }
        if ( !$("#BDSP1").is(':checked') && !$("#BDSP2").is(':checked') ) {
            alert('Please Select BDSP')
            $("#BDSP1").focus()
            return false
        }
        if ( !$("#PLA1").is(':checked') && !$("#PLA2").is(':checked') ) {
            alert('Please Select PLA')
            $("#PLA1").focus()
            return false
        }
        if ( !$("#SV1").is(':checked') && !$("#SV2").is(':checked') ) {
            alert('Please Select SV')
            $("#SV1").focus()
            return false
        }

        if ( !confirm('Save Data Now ?')) 
            return false;  //ยืนยันก่อนบันทึกข้อมูล

    })

})
</script>
