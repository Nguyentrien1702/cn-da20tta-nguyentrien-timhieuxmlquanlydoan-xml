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
    
        if ($loaitaikhoan === "Giangvien") {
        // tài khoản Giangvien
        // Đọc tệp XML
            $xml_giangvien = simplexml_load_file('../../QuanlyXML/Giangvien.xml');
            foreach ($xml_giangvien->giangvien as $giangvien) {
                if (((string) $giangvien['msgv'] === $username) && ((string) $giangvien->tengiangvien === $Tennguoidung)) {
                    return "Giangvien";
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
    if ($result === "Giangvien") {
        
        updateAccount($xmlFilePath, $username, $pass, $result);
        echo ("<script language='javascript'>
                alert('Đổi mật khẩu thành công');
                window.location.assign('../../Giaodien/Giangvien/index_giangvien.php');
            </script>");
    } 
    else {
        header("Location: ../../Giaodien/Giangvien/doimatkhau.php?tentaikhoan=".urlencode($username)."&p=".urlencode($result));
        exit;
    }
}

?>