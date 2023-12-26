<?php
require_once 'Xuly_dangky.php';
$xmlFilePath = '../../QuanlyXML/Dangky.xml';
    if(isset($_GET["madetai_huy"])){
        $madetai_huy = $_GET["madetai_huy"];
        deletedangky($xmlFilePath, $madetai_huy);
        myAlert("Hủy đăng ký thành công!", "../../Giaodien/Sinhvien/index_sinhvien.php");
    }
?>

