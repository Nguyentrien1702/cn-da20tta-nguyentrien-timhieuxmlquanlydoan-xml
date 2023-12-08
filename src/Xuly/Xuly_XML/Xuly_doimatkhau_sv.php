<?php
require("Xuly_taikhoan.php");
function kiemTraDangNhap($username) {
    // Đọc tệp XML
    $xml = simplexml_load_file('../../QuanlyXML/Taikhoan.xml');

    foreach ($xml->taikhoan as $taikhoan) {
        if ((string) $taikhoan['tentaikhoan'] === $username) {
                return (string) $taikhoan->loaitaikhoan;
        }
    }
    return "Tài khoản không tồn tại";
}
function kiemTraTennguoidung($username, $Tennguoidung) {
    $loaitaikhoan = kiemTraDangNhap($username);
    
        if ($loaitaikhoan === "Sinhvien") {
        // tài khoản Sinhvien
        // Đọc tệp XML
            $xml_sinhvien = simplexml_load_file('../../QuanlyXML/Sinhvien.xml');
            foreach ($xml_sinhvien->sinhvien as $sinhvien) {
                if (((string) $sinhvien['mssv'] === $username) && ((string) $sinhvien->tensinhvien === $Tennguoidung)) {
                    return "Sinhvien";
                }  
            }
            return "Sai tên người dùng";
        }else return $loaitaikhoan;
}

if (isset($_POST['sbmcapnhat'])) {
    $username = $_POST['txttentk'];
    $tennguoidung = $_POST['txthoten'];
    $pass = $_POST['txtmatkhaumoi'];
    $passnew = $_POST['txtxacnhanmatkhau'];

    $result = kiemTraTennguoidung($username, $tennguoidung);
    if ($result === "Sinhvien") {
        
        updateAccount($xmlFilePath, $username, $pass, $result);
        echo ("<script language='javascript'>
                alert('Đổi mật khẩu thành công');
                window.location.assign('../../Giaodien/Sinhvien/index_sinhvien.php');
            </script>");
    } 
    else {
        header("Location: ../../Giaodien/Sinhvien/doimatkhau.php?tentaikhoan=".urlencode($username)."&p=".urlencode($result));
        exit;
    }
}

?>