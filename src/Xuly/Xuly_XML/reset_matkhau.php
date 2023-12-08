<?php
// Hàm cập nhật thông tin tài khoản
function updateAccount($username) {
    $xmlFilePath = '../../QuanlyXML/Taikhoan.xml';
    $xml = simplexml_load_file($xmlFilePath);
    // $hashpass = hashPassword($newPassword, PASSWORD_DEFAULT);
    // Tìm và cập nhật thông tin tài khoản
    foreach ($xml->taikhoan as $account) {
        if ((string)$account['tentaikhoan'] === $username) {
            $account_rs = $account['tentaikhoan'] . "@";
            // Cập nhật mật khẩu và loại tài khoản
            $account->matkhau = md5($account_rs);//$hashpass;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật tài khoản
            break;
        }
    }
}

if(isset($_GET["username"])){
    updateAccount($_GET["username"]);
    header("location: ../../Giaodien/Admin/Taikhoan.php");
}
?>