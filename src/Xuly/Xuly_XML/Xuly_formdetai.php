<?php
session_start();
require_once 'Xuly_detai.php'; // Đường dẫn đến file chứa các hàm xử lý với đề tài
$xmlFilePath = '../../QuanlyXML/Detai.xml';
$xml = simplexml_load_file($xmlFilePath);

// Lấy dữ liệu POST raw
$rawData = file_get_contents("php://input");

// Giải mã dữ liệu JSON
$data = json_decode($rawData, true);

// Truy cập dữ liệu
if (isset($data['data'])) {
    $receivedData = $data['data'];
    $trangthai = "0";
    $lastProject = $xml->xpath('//detai[last()]');
    $lastMadt = $lastProject[0]['madetai'];
    // Tách phần số từ mã đề tài cuối cùng
    $newNumber = intval(preg_replace('/[^0-9]/', '', $lastMadt));

    // Xử lý dữ liệu theo cách cần thiết
    foreach ($receivedData as $item) {
        // Truy cập các thuộc tính riêng lẻ, ví dụ: $item['user'], $item['tendetai'], v.v.
        $maloaidoan = $item['maloai'];
        $tendetai = $item['tendetai'];
        $mota = $item['mota'];
        $loaidetai = $item['loaidetai'];
        $namhoc = $item['namhoc'];
        $msgv = $item['user'];
        $ma =explode("-", $maloaidoan);
        $manganh = end($ma);

        // Tăng giá trị của phần số lên một
        $newNumber = $newNumber + 1;
        $madetai = $maloaidoan ."-". sprintf("%02d", $newNumber);

        // Kiểm tra mã đề tài đã tồn tại chưa
        if (!isMadetaiExists($xmlFilePath, $madetai)) {
            // Thêm đề tài vào tệp XML
            addDetai($xmlFilePath, $madetai, $tendetai, $mota, $maloaidoan, $loaidetai, $msgv, $manganh, $namhoc);
        }
    }
}

?>