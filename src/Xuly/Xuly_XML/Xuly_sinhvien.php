<?php
require '../../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Sinhvien.xml';

// Hàm kiểm tra xem Giảng viên có tồn tại hay không
function isSinhvienExists($xmlFilePath, $mssv) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->sinhvien as $sinhvien) {
        if ((string)$sinhvien['mssv'] == $mssv) {
            return true;
        }
    }
    return false;
}

// Hàm thêm tài khoản mới
function addAccount($username, $password, $accountType) {
    $xmlFilePath_taikhoan = '../../QuanlyXML/Taikhoan.xml';
    $xml = simplexml_load_file($xmlFilePath_taikhoan);

    $newAccount = $xml->addChild('taikhoan');
    $newAccount->addAttribute('tentaikhoan', $username);
    $newAccount->addChild('matkhau', md5($password));
    $newAccount->addChild('loaitaikhoan', $accountType);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath_taikhoan);
}

// Hàm xóa tài khoản
function deleteAccount($username) {
    $xmlFilePath_taikhoan = '../../QuanlyXML/Taikhoan.xml';
    $xml = simplexml_load_file($xmlFilePath_taikhoan);
    $account = $xml->xpath("//taikhoan[@tentaikhoan='$username']");

    unset($account[0][0]);

    $xml->asXML($xmlFilePath_taikhoan);
}

// Hàm thêm Lớp mới
function addsinhvien($xmlFilePath, $mssv, $tensinhvien, $gioitinh, $sodienthoai, $email, $malop) {
    $xml = simplexml_load_file($xmlFilePath);

    $newsinhvien = $xml->addChild('sinhvien');
    $newsinhvien->addAttribute('mssv', $mssv);
    $newsinhvien->addChild('tensinhvien', $tensinhvien);
    $newsinhvien->addChild('gioitinh', $gioitinh);
    $newsinhvien->addChild('sodienthoai', $sodienthoai);
    $newsinhvien->addChild('email', $email);
    $newsinhvien->addChild('malop', $malop);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath);
    $matkhau = $mssv."@";
    $loai = "Sinhvien";
    addAccount($mssv, $matkhau, $loai);
}

// Hàm cập nhật thông tin Giảng viên
function updatesinhvien($xmlFilePath, $mssv, $tensinhvien, $gioitinh, $sodienthoai, $email, $malop) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Giảng viên
    foreach ($xml->sinhvien as $sinhvien) {
        if ((string)$sinhvien['mssv'] === $mssv) {
            // Cập nhật Giảng viên
            $sinhvien->tensinhvien = $tensinhvien;
            $sinhvien->gioitinh = $gioitinh;
            $sinhvien->sodienthoai = $sodienthoai;
            $sinhvien->email = $email;
            $sinhvien->malop = $malop;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Giảng viên
            break;
        }
    }
}

// Hàm xóa Giảng viên
function deletesinhvien($xmlFilePath, $mssv) {
    $xml = simplexml_load_file($xmlFilePath);
    $sinhvien = $xml->xpath("//sinhvien[@mssv='$mssv']");
    deleteAccount($mssv);
    unset($sinhvien[0][0]);

    $xml->asXML($xmlFilePath);
    
}

function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}

if(isset($_POST["sbmthem"])){

    $mssv = $_POST["txtmssv"];
    $tensinhvien = $_POST["txttensinhvien"];
    $gioitinh = $_POST["rdgioitinh"];
    $sodienthoai = $_POST["txtsodienthoai"];
    $email = $_POST["txtemail"];
    $malop = $_POST["txtmalop"];

    if(issinhvienExists($xmlFilePath, $mssv)){
        myAlert("Mã sinh viên đã tồn tại","../../Giaodien/Admin/sinhvien.php?mssv=$mssv&tensinhvien=$tensinhvien&gioitinh=$gioitinh&sodienthoai=$sodienthoai&email=$email&malop=$malop");
    }
    else{
        addsinhvien($xmlFilePath, $mssv, $tensinhvien, $gioitinh, $sodienthoai, $email, $malop);
        header("Location: ../../Giaodien/Admin/sinhvien.php");
    }
}
if(isset($_POST["sbmhuy"])){
    header("Location: ../../Giaodien/Admin/sinhvien.php");
}
if(isset($_POST["sbmcapnhat"])){
    $mssv = $_POST["txtmssv"];
    $tensinhvien = $_POST["txttensinhvien"];
    $gioitinh = $_POST["rdgioitinh"];
    $sodienthoai = $_POST["txtsodienthoai"];
    $email = $_POST["txtemail"];
    $malop = $_POST["txtmalop"];
    updatesinhvien($xmlFilePath, $mssv, $tensinhvien, $gioitinh, $sodienthoai, $email, $malop);
    header("Location: ../../Giaodien/Admin/sinhvien.php");
}
if(isset($_GET["mssv"])){
        $ma = $_GET["mssv"];
        deletesinhvien($xmlFilePath, $ma);
        myAlert("Xóa thành công","../../Giaodien/Admin/sinhvien.php");
    }

?>
