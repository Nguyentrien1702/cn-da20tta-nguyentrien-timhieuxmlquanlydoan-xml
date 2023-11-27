<?php
require '../../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Lop.xml';

// Hàm kiểm tra xem Ngành có tồn tại hay không
function isLopExists($xmlFilePath, $malop) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->lop as $lop) {
        if ((string)$lop['malop'] == $malop) {
            return true;
        }
    }
    return false;
}

// Hàm thêm Lớp mới
function addLop($xmlFilePath, $malop, $tenlop, $khoa, $manganh) {
    $xml = simplexml_load_file($xmlFilePath);

    $newLop = $xml->addChild('lop');
    $newLop->addAttribute('malop', $malop);
    $newLop->addChild('tenlop', $tenlop);
    $newLop->addChild('khoa', $khoa);
    $newLop->addChild('manganh', $manganh);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath);
}

// Hàm cập nhật thông tin Ngành
function updateLop($xmlFilePath, $malop, $tenlop, $khoa, $manganh) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Ngành
    foreach ($xml->lop as $lop) {
        if ((string)$lop['malop'] === $malop) {
            // Cập nhật Ngành
            $lop->tenlop = $tenlop;
            $lop->khoa = $khoa;
            $lop->manganh = $manganh;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Ngành
            break;
        }
    }
}

// Hàm xóa Ngành
function deleteLop($xmlFilePath, $malop) {
    $xml = simplexml_load_file($xmlFilePath);
    $lop = $xml->xpath("//lop[@malop='$malop']");

    unset($lop[0][0]);

    $xml->asXML($xmlFilePath);
    
}

function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}

if(isset($_POST["sbmthem"])){

    $malop = $_POST["txtmalop"];
    $tenlop = $_POST["txttenlop"];
    $khoa = $_POST["txtkhoa"];
    $manganh = $_POST["txtmanganh"];

    if(isLopExists($xmlFilePath, $malop)){
        myAlert("Mã ngành đã tồn tại","../../Giaodien/Admin/Them_lop.php?malop=$malop&tenlop=$tenlop&khoa=$khoa&manganh=$manganh");
    }
    else{
        addLop($xmlFilePath, $malop, $tenlop, $khoa, $manganh);
        header("Location: ../../Giaodien/Admin/lop.php");
    }
}
if(isset($_POST["sbmhuy"])){
    header("Location: ../../Giaodien/Admin/lop.php");
}
if(isset($_POST["sbmcapnhat"])){
    $malop = $_POST["txtmalop"];
    $tenlop = $_POST["txttenlop"];
    $khoa = $_POST["txtkhoa"];
    $manganh = $_POST["txtmanganh"];
    updateLop($xmlFilePath, $malop, $tenlop, $khoa, $manganh);
    header("Location: ../../Giaodien/Admin/lop.php");
}
if(isset($_GET["malop"])){
        $ma = $_GET["malop"];
        deleteLop($xmlFilePath, $ma);
        myAlert("Xóa thành công","../../Giaodien/Admin/lop.php");
    }

?>
