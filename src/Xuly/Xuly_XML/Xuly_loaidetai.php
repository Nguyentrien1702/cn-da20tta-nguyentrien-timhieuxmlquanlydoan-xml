<?php

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Loaidetai.xml';

// Hàm kiểm tra xem Loại đề tài có tồn tại hay không
function isLoaidetaiExists($xmlFilePath, $maloaidetai) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->loaidetai as $loaidetai) {
        if ((string)$loaidetai['maloaidetai'] == $maloaidetai) {
            return true;
        }
    }
    return false;
}

// Hàm thêm Loại đề tài mới
function addLoaidetai($xmlFilePath, $maloaidetai, $tenloaidetai) {
    $xml = simplexml_load_file($xmlFilePath);

    $newLoaidetai = $xml->addChild('loaidetai');
    $newLoaidetai->addAttribute('maloaidetai', $maloaidetai);
    $newLoaidetai->addChild('tenloaidetai', $tenloaidetai);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath);
}

// Hàm cập nhật thông tin Loại đề tài
function updateLoaidetai($xmlFilePath, $maloaidetai, $tenloaidetai) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Loại đề tài
    foreach ($xml->loaidetai as $loaidetai) {
        if ((string)$loaidetai['maloaidetai'] === $maloaidetai) {
            // Cập nhật Loại đề tài
            $loaidetai->tenloaidetai = $tenloaidetai;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Loại đề tài
            break;
        }
    }
}

// Hàm xóa Loại đề tài
function deleteLoaidetai($xmlFilePath, $maloaidetai) {
    $xml = simplexml_load_file($xmlFilePath);
    $loaidetai = $xml->xpath("//loaidetai[@maloaidetai='$maloaidetai']");

    unset($loaidetai[0][0]);

    $xml->asXML($xmlFilePath);
    
}

function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}

if(isset($_POST["sbmthem"])){

    $maloaidetai = $_POST["txtmaloaidetai"];
    $tenloaidetai = $_POST["txttenloaidetai"];

    if(isLoaidetaiExists($xmlFilePath, $maloaidetai)){
        myAlert("Mã Loại đề tài đã tồn tại","../../Giaodien/Admin/loaidetai.php?maloaidetai=$maloaidetai&tenloaidetai=$tenloaidetai");
    }
    else{
        addLoaidetai($xmlFilePath, $maloaidetai, $tenloaidetai);
        header("Location: ../../Giaodien/Admin/loaidetai.php");
    }
}
if(isset($_POST["sbmhuy"])){
    header("Location: ../../Giaodien/Admin/loaidetai.php");
}
if(isset($_POST["sbmcapnhat"])){
    $maloaidetai = $_POST["txtmaloaidetai"];
    $tenloaidetai = $_POST["txttenloaidetai"];
    updateLoaidetai($xmlFilePath, $maloaidetai, $tenloaidetai);
    header("Location: ../../Giaodien/Admin/loaidetai.php");
}
if(isset($_GET["maloaidetai"])){
        $ma = $_GET["maloaidetai"];
        deleteLoaidetai($xmlFilePath, $ma);
        myAlert("Xóa thành công","../../Giaodien/Admin/loaidetai.php");
    }

?>
