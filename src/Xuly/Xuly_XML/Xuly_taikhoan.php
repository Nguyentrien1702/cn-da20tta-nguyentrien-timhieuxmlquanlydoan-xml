<?php
require 'vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = 'QuanlyXML/Taikhoan.xml';

// Hàm kiểm tra xem tài khoản có tồn tại hay không
function isAccountExists($xmlFilePath, $username) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->Taikhoan as $taikhoan) {
        if ((string)$taikhoan['Tentaikhoan'] == $username) {
            return true;
        }
    }
    return false;
}

// Hàm thêm tài khoản mới
function addAccount($xmlFilePath, $username, $password, $accountType) {
    $xml = simplexml_load_file($xmlFilePath);
    
    if (isAccountExists($xmlFilePath, $username)) {
        return "Tài khoản đã tồn tại";
    }

    $newAccount = $xml->addChild('Taikhoan');
    $newAccount->addAttribute('Tentaikhoan', $username);
    $newAccount->addChild('Matkhau', $password);
    $newAccount->addChild('Loaitaikhoan', $accountType);

    $xml->asXML($xmlFilePath);
    return "Tài khoản đã được thêm thành công";
}

// Hàm cập nhật thông tin tài khoản
function updateAccount($xmlFilePath, $username, $newPassword, $newAccountType) {
    $xml = simplexml_load_file($xmlFilePath);
    $account = $xml->xpath("//Taikhoan[@Tentaikhoan='$username']");

    if (empty($account)) {
        return "Tài khoản không tồn tại";
    }
    else{
        $account = $account[0];
        $account->addChild('Matkhau', $newPassword);
        $account->addChild('Loaitaikhoan', $newAccountType);

        $xml->asXML($xmlFilePath);
        return "Tài khoản đã được cập nhật thành công";
    }
}

// Hàm xóa tài khoản
function deleteAccount($xmlFilePath, $username) {
    $xml = simplexml_load_file($xmlFilePath);
    $account = $xml->xpath("//Taikhoan[@Tentaikhoan='$username']");

    if (empty($account)) {
        return "Tài khoản không tồn tại";
    }

    unset($account[0][0]);

    $xml->asXML($xmlFilePath);
    return "Tài khoản đã được xóa thành công";
}

// Hàm insert dữ liệu từ file Excel
function insertDataFromExcel($xmlFilePath, $excelFilePath) {
    $xml = simplexml_load_file($xmlFilePath);
    $objPHPExcel = PHPExcel_IOFactory::load($excelFilePath);

    $worksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();

    for ($row = 2; $row <= $highestRow; $row++) {
        $username = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
        $password = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
        $accountType = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

        if (!isAccountExists($xmlFilePath, $username)) {
            $newAccount = $xml->addChild('Taikhoan');
            $newAccount->addAttribute('Tentaikhoan', $username);
            $newAccount->addChild('Matkhau', $password);
            $newAccount->addChild('Loaitaikhoan', $accountType);
        }
    }

    $xml->asXML($xmlFilePath);
    return "Dữ liệu từ Excel đã được thêm vào XML thành công";
}

// Sử dụng các hàm
$username = "110120081";
$password = "new_password";
$accountType = "Sinhvien";

// Kiểm tra tài khoản tồn tại
if (isAccountExists($xmlFilePath, $username)) {
    echo "Tài khoản tồn tại";
} else {
    echo "Tài khoản không tồn tại";
}

// Thêm tài khoản mới
echo addAccount($xmlFilePath, $username, $password, $accountType);

// Cập nhật tài khoản
echo updateAccount($xmlFilePath, $username, $password, $accountType);

// Xóa tài khoản
echo deleteAccount($xmlFilePath, $username);

// Thêm dữ liệu từ Excel
$excelFilePath = 'path/to/your/excel/file.xlsx';
echo insertDataFromExcel($xmlFilePath, $excelFilePath);
?>
