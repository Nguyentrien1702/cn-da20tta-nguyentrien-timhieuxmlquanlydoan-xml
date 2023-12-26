<?php
session_start();
require_once 'Xuly_dangky.php';
$xmlFilePath = '../../QuanlyXML/Dangky.xml';
    if(isset($_POST["sbmcapnhat_gv"])){
        $madetai = $_POST["madetai_sua"];
        $msgv_hd = $_POST["giangvien"];
        $tennguoidung = $_SESSION["tennguoidung"];
        updateGv_hd($xmlFilePath, $madetai, $msgv_hd);
        if($tennguoidung == "admin"){
            myAlert("cập nhật thành công!", "../../Giaodien/Admin/dsdangky.php");
        }else{
            myAlert("cập nhật thành công!", "../../Giaodien/Giangvien/dscanhan.php");
        }
        
    }
?>

