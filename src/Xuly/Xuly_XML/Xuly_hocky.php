<?php
require '../../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Hocky.xml';

// Hàm kiểm tra xem Học kỳ có tồn tại hay không
function isHockyExists($xmlFilePath, $mahknk) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->hocky as $hocky) {
        if ((string)$hocky['mahk-nk'] == $mahknk) {
            return true;
        }
    }
    return false;
}

// Hàm thêm Học kỳ mới
function addHocky($xmlFilePath, $mahknk, $tenhocky, $nienkhoa, $ngaybatdau, $ngayketthuc) {
    $xml = simplexml_load_file($xmlFilePath);

    $newHocky = $xml->addChild('hocky');
    $newHocky->addAttribute('mahk-nk', $mahknk);
    $newHocky->addChild('tenhocky', $tenhocky);
    $newHocky->addChild('nienkhoa', $nienkhoa);
    $newHocky->addChild('ngaybatdau', $ngaybatdau);
    $newHocky->addChild('ngayketthuc', $ngayketthuc);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath);
}

// Hàm cập nhật thông tin Ngành
function updateHocky($xmlFilePath, $mahknk, $tenhocky, $nienkhoa, $ngaybatdau, $ngayketthuc) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Ngành
    foreach ($xml->hocky as $hocky) {
        if ((string)$hocky['mahk-nk'] === $mahknk) {
            // Cập nhật Ngành
            $hocky->tenhocky = $tenhocky;
            $hocky->nienkhoa = $nienkhoa;
            $hocky->ngaybatdau = $ngaybatdau;
            $hocky->ngayketthuc = $ngayketthuc;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Ngành
            break;
        }
    }
}

// Hàm xóa Ngành
function deleteHocky($xmlFilePath, $mahknk) {
    $xml = simplexml_load_file($xmlFilePath);
    $hocky = $xml->xpath("//hocky[@mahk-nk='$mahknk']");

    unset($hocky[0][0]);

    $xml->asXML($xmlFilePath);
    
}

function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}

if(isset($_POST["sbmthem"])){
    
    $mahknk = $_POST["txtmahk-nk"];
    $tenhocky = $_POST["txttenhocky"];
    $nienkhoa = $_POST["txtnienkhoa"];
    $ngaybatdau = $_POST["dtngaybatdau"];
    $ngayketthuc = $_POST["dtngayketthuc"];


    if(isHockyExists($xmlFilePath, $mahknk)){
        myAlert("Mã học kỳ đã tồn tại","../../Giaodien/Admin/hocky.php?mahk-nk=$mahknk&tenhocky=$tenhocky&nienkhoa=$nienkhoa&ngaybatdau=$ngaybatdau&ngayketthuc=$ngayketthuc");
    }
    else{
        addHocky($xmlFilePath, $mahknk, $tenhocky, $nienkhoa, $ngaybatdau, $ngayketthuc);
        header("Location: ../../Giaodien/Admin/hocky.php");
    }
}
if(isset($_POST["sbmhuy"])){
    header("Location: ../../Giaodien/Admin/hocky.php");
}
if(isset($_POST["sbmcapnhat"])){
    $mahknk = $_POST["txtmahk-nk"];
    $tenhocky = $_POST["txttenhocky"];
    $nienkhoa = $_POST["txtnienkhoa"];
    $ngaybatdau = $_POST["dtngaybatdau"];
    $ngayketthuc = $_POST["dtngayketthuc"];

    updateHocky($xmlFilePath, $mahknk, $tenhocky, $nienkhoa, $ngaybatdau, $ngayketthuc);
    header("Location: ../../Giaodien/Admin/hocky.php");
}
if(isset($_GET["mahk-nk"])){
        $ma = $_GET["mahk-nk"];
        deleteHocky($xmlFilePath, $ma);
        myAlert("Xóa thành công","../../Giaodien/Admin/hocky.php");
    }

?>
