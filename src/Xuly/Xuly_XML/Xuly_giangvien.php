<?php
require '../../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Giangvien.xml';

// Hàm kiểm tra xem Giảng viên có tồn tại hay không
function isGiangvienExists($xmlFilePath, $msgv) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->giangvien as $giangvien) {
        if ((string)$giangvien['msgv'] == $msgv) {
            return true;
        }
    }
    return false;
}

// Hàm thêm Lớp mới
function addGiangvien($xmlFilePath, $msgv, $tengiangvien, $gioitinh, $sodienthoai, $email, $phong) {
    $xml = simplexml_load_file($xmlFilePath);

    $newGiangvien = $xml->addChild('giangvien');
    $newGiangvien->addAttribute('msgv', $msgv);
    $newGiangvien->addChild('tengiangvien', $tengiangvien);
    $newGiangvien->addChild('gioitinh', $gioitinh);
    $newGiangvien->addChild('sodienthoai', $sodienthoai);
    $newGiangvien->addChild('email', $email);
    $newGiangvien->addChild('phong', $phong);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath);
}

// Hàm cập nhật thông tin Giảng viên
function updateGiangvien($xmlFilePath, $msgv, $tengiangvien, $gioitinh, $sodienthoai, $email, $phong) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Giảng viên
    foreach ($xml->giangvien as $giangvien) {
        if ((string)$giangvien['msgv'] === $msgv) {
            // Cập nhật Giảng viên
            $giangvien->tengiangvien = $tengiangvien;
            $giangvien->gioitinh = $gioitinh;
            $giangvien->sodienthoai = $sodienthoai;
            $giangvien->email = $email;
            $giangvien->phong = $phong;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Giảng viên
            break;
        }
    }
}

// Hàm xóa Giảng viên
function deleteGiangvien($xmlFilePath, $msgv) {
    $xml = simplexml_load_file($xmlFilePath);
    $giangvien = $xml->xpath("//giangvien[@msgv='$msgv']");

    unset($giangvien[0][0]);

    $xml->asXML($xmlFilePath);
    
}
// Hàm xóa tài khoản
function deleteAccount( $username) {
    $xmlFilePath = '../../QuanlyXML/Taikhoan.xml';
    $xml = simplexml_load_file($xmlFilePath);
    $account = $xml->xpath("//taikhoan[@tentaikhoan='$username']");
    unset($account[0][0]);

    $xml->asXML($xmlFilePath);
}

function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}

if(isset($_POST["sbmthem"])){

    $msgv = $_POST["txtmsgv"];
    $tengiangvien = $_POST["txttengiangvien"];
    $gioitinh = $_POST["rdgioitinh"];
    $sodienthoai = $_POST["txtsodienthoai"];
    $email = $_POST["txtemail"];
    $phong = $_POST["txtphong"];

    if(isGiangvienExists($xmlFilePath, $msgv)){
        myAlert("Mã giảng viên đã tồn tại","../../Giaodien/Admin/giangvien.php?msgv=$msgv&tengiangvien=$tengiangvien&gioitinh=$gioitinh&sodienthoai=$sodienthoai&email=$email&phong=$phong");
    }
    else{
        addGiangvien($xmlFilePath, $msgv, $tengiangvien, $gioitinh, $sodienthoai, $email, $phong);
        header("Location: ../../Giaodien/Admin/giangvien.php");
    }
}
if(isset($_POST["sbmhuy"])){
    header("Location: ../../Giaodien/Admin/giangvien.php");
}
if(isset($_POST["sbmcapnhat"])){
    $msgv = $_POST["txtmsgv"];
    $tengiangvien = $_POST["txttengiangvien"];
    $gioitinh = $_POST["rdgioitinh"];
    $sodienthoai = $_POST["txtsodienthoai"];
    $email = $_POST["txtemail"];
    $phong = $_POST["txtphong"];
    updateGiangvien($xmlFilePath, $msgv, $tengiangvien, $gioitinh, $sodienthoai, $email, $phong);
    header("Location: ../../Giaodien/Admin/giangvien.php");
}
if(isset($_GET["msgv"])){
        $ma = $_GET["msgv"];
        deleteAccount($ma);
        deleteGiangvien($xmlFilePath, $ma);
        header("Location: ../../Giaodien/Admin/giangvien.php");
    }

?>
