<?php
session_start();
require("Xuly_XML/Xuly_taikhoan.php");
// Hàm kiểm tra thông tin đăng nhập
function kiemTraDangNhap($username) {
    // Đọc tệp XML
    $xml = simplexml_load_file('../QuanlyXML/Taikhoan.xml');

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
            $xml_sinhvien = simplexml_load_file('../QuanlyXML/Sinhvien.xml');
            foreach ($xml_sinhvien->sinhvien as $sinhvien) {
                if (((string) $sinhvien['mssv'] === $username) && ((string) $sinhvien->tensinhvien === $Tennguoidung)) {
                    return "Sinhvien";
                }  
            }
            return "Sai tên người dùng";
        } elseif ($loaitaikhoan === "Giangvien") {
            // tài khoản Giangvien
            // Đọc tệp XML
                $xml_giangvien = simplexml_load_file('../QuanlyXML/Giangvien.xml');
                foreach ($xml_giangvien->Giangvien as $giangvien) {
                    if ((string) $giangvien['msgv'] === $username && (string) $giangvien->tengiangvien === $Tennguoidung) {
                        return "Giangvien";
                    }
                }
                    return "Sai tên người dùng";
                 
            }else{
                return $loaitaikhoan;
            }
}


if (isset($_POST['sbxacnhan'])) {
    $username = $_POST['txttentaikhoan'];
    $tennguoidung = $_POST['txthoten'];
    $pass = $_POST['txtmatkhau'];
    $passnew = $_POST['txtxnmatkhau'];

    $result = kiemTraTennguoidung($username, $tennguoidung);
    if ($result === "Sinhvien" || $result === "Giangvien") {
        
        updateAccount($xmlFilePath, $username, $pass, $result);
        echo ("<script language='javascript'>
                alert('Đổi mật khẩu thành công');
                window.location.assign('../index.php');
            </script>");
    } else {
        header("Location: ../Giaodien/Quenmatkhau.php?tentaikhoan=".urlencode($username)."&p=".urlencode($result));
        exit;
    }
}
elseif (isset($_POST["sbhuy"])) {
    header("Location: ../index.php");
}

?>