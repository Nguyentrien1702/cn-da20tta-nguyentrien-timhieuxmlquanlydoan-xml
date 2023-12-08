<?php
session_start();
require_once 'Xuly_detai.php'; // Đường dẫn đến file chứa các hàm xử lý với đề tài
$xmlFilePath = '../../QuanlyXML/Detai.xml';
$xml = simplexml_load_file($xmlFilePath);
if (isset($_POST["sbmthem"])) {
    // Lấy dữ liệu từ form
    $tendetai = $_POST['txttendetai'];
    $mota = $_POST['txtmota'];
    $mota = htmlspecialchars($mota);
    $maloaidoan = $_POST['txtmaloaidoan'];
    $msgv = $_SESSION["user"];
    $ma =explode("-", $maloaidoan);
    $manganh = end($ma);
    $namhoc = "2023 - 2024";

    $lastProject = $xml->xpath('//detai[last()]');
    $lastMadt = $lastProject[0]['madetai'];
    // Tách phần số từ mã đề tài cuối cùng
    $lastNumber = intval(preg_replace('/[^0-9]/', '', $lastMadt));
    // Tăng giá trị của phần số lên một
    $newNumber = $lastNumber + 1;
    $madetai = $maloaidoan ."-". sprintf("%02d", $newNumber);
  
        // Kiểm tra mã đề tài đã tồn tại chưa
        if (!isMadetaiExists($xmlFilePath, $madetai)) {
            // Thêm đề tài vào tệp XML
            addDetai($xmlFilePath, $madetai, $tendetai, $mota, $maloaidoan, $msgv, $manganh, $namhoc);
            header("location: ../../Giaodien/Giangvien/detai.php");
        }
}
?>