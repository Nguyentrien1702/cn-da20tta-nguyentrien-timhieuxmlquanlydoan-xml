<?php
require '../../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Nganh.xml';

// Hàm kiểm tra xem Ngành có tồn tại hay không
function isNganhExists($xmlFilePath, $manganh) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->nganh as $nganh) {
        if ((string)$nganh['manganh'] == $manganh) {
            return true;
        }
    }
    return false;
}

// Hàm thêm Ngành mới
function addNganh($xmlFilePath, $manganh, $tennganh) {
    $xml = simplexml_load_file($xmlFilePath);

    $newNganh = $xml->addChild('nganh');
    $newNganh->addAttribute('manganh', $manganh);
    $newNganh->addChild('tennganh', $tennganh);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath);
}

// Hàm cập nhật thông tin Ngành
function updateNganh($xmlFilePath, $manganh, $tennganh) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Ngành
    foreach ($xml->nganh as $nganh) {
        if ((string)$nganh['manganh'] === $manganh) {
            // Cập nhật Ngành
            $nganh->tennganh = $tennganh;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Ngành
            break;
        }
    }
}

// Hàm xóa Ngành
function deleteNganh($xmlFilePath, $manganh) {
    $xml = simplexml_load_file($xmlFilePath);
    $nganh = $xml->xpath("//nganh[@manganh='$manganh']");

    unset($nganh[0][0]);

    $xml->asXML($xmlFilePath);
    
}

function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}

if(isset($_POST["sbmthem"])){

    $manganh = $_POST["txtmanganh"];
    $tennganh = $_POST["txttennganh"];

    if(isNganhExists($xmlFilePath, $manganh)){
        myAlert("Mã ngành đã tồn tại","../../Giaodien/Admin/Them_nganh.php?manganh=$manganh&tennganh=$tennganh");
    }
    else{
        addNganh($xmlFilePath, $manganh, $tennganh);
        header("Location: ../../Giaodien/Admin/nganh.php");
    }
}
if(isset($_POST["sbmhuy"])){
    header("Location: ../../Giaodien/Admin/nganh.php");
}
if(isset($_POST["sbmcapnhat"])){
    $manganh = $_POST["txtmanganh"];
    $tennganh = $_POST["txttennganh"];
    updateNganh($xmlFilePath, $manganh, $tennganh);
    header("Location: ../../Giaodien/Admin/nganh.php");
}
if(isset($_GET["manganh"])){
        $ma = $_GET["manganh"];
        deleteNganh($xmlFilePath, $ma);
        myAlert("Xóa thành công","../../Giaodien/Admin/nganh.php");
    }

?>
