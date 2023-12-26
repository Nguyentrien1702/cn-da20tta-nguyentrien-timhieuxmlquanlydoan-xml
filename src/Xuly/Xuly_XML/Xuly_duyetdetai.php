<?php
session_start();
require_once 'Xuly_detai.php'; // Đường dẫn đến file chứa các hàm xử lý với đề tài
$xmlFilePath = '../../QuanlyXML/Detai.xml';
$xml = simplexml_load_file($xmlFilePath);
if (isset($_GET["duyet_madetai"])) {
    $madetai = $_GET["duyet_madetai"];
    updateDetaiTrangThai($xmlFilePath, $madetai, "1");
    header("location: ../../Giaodien/Admin/Giaodien_admin.php");
}elseif(isset($_GET["loaibo_madetai"])){
    $madetai = $_GET["loaibo_madetai"];
    deleteDetai($xmlFilePath, $madetai);
    header("location: ../../Giaodien/Admin/Giaodien_admin.php");
}


if(isset($_POST["sbmghichu"])){
    $madetai = $_POST["madetai"];
    $ghichu = $_POST["lido"];
    $trangthai = "2";

    updateDetaighichu($xmlFilePath, $madetai, $trangthai, $ghichu);
    header("location: ../../Giaodien/Admin/Giaodien_admin.php");
}
?>