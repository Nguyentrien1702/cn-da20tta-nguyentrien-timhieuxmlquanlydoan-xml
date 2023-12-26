<?php
require_once 'Xuly_dangky.php'; // Đường dẫn đến file chứa các hàm xử lý với đề tài
$xmlFilePath = '../../QuanlyXML/Dangky.xml';

if(isset($_GET['mssv_dk'], $_GET['madetai'], $_GET['msgv_hd'], $_GET['namhoc'])){
    $madetai = $_GET['madetai'];
    $mssv = $_GET['mssv_dk'];
    $msgv_hd = $_GET['msgv_hd'];
    $namhoc = $_GET['namhoc'];

    if(issinhvienExists($xmlFilePath, $mssv, $namhoc)){
        myAlert("Sinh viên đã đăng ký!", "../../Giaodien/Sinhvien/dangkydoan.php");
    }else{
        addDangky($xmlFilePath, $madetai, $mssv, $msgv_hd, $namhoc);
        myAlert("Đăng ký thành công!", "../../Giaodien/Sinhvien/index_sinhvien.php");
    }
}

?>