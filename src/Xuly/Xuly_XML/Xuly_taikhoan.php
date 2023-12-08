<?php
require '../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Taikhoan.xml';

// Hàm kiểm tra xem tài khoản có tồn tại hay không
function isAccountExists($xmlFilePath, $username) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->taikhoan as $taikhoan) {
        if ((string)$taikhoan['tentaikhoan'] == $username) {
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

    $newAccount = $xml->addChild('taikhoan');
    $newAccount->addAttribute('tentaikhoan', $username);
    $newAccount->addChild('matkhau', md5($password));
    $newAccount->addChild('loaitaikhoan', $accountType);

    $xml->asXML($xmlFilePath);
    return "Tài khoản đã được thêm thành công";
}

// Hàm cập nhật thông tin tài khoản
function updateAccount($xmlFilePath, $username, $newPassword, $newAccountType) {
    $xmlFilePath = '../../QuanlyXML/Taikhoan.xml';
    $xml = simplexml_load_file($xmlFilePath);
    // $hashpass = hashPassword($newPassword, PASSWORD_DEFAULT);
    // Tìm và cập nhật thông tin tài khoản
    foreach ($xml->taikhoan as $account) {
        if ((string)$account['tentaikhoan'] === $username) {
            // Cập nhật mật khẩu và loại tài khoản
            $account->matkhau = md5($newPassword);//$hashpass;
            $account->loaitaikhoan = $newAccountType;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật tài khoản
            break;
        }
    }
}

// Hàm xóa tài khoản
function deleteAccount($xmlFilePath, $username) {
    $xml = simplexml_load_file($xmlFilePath);
    $account = $xml->xpath("//taikhoan[@tentaikhoan='$username']");

    if (empty($account)) {
        return "Tài khoản không tồn tại";
    }

    unset($account[0][0]);

    $xml->asXML($xmlFilePath);
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
            $newAccount = $xml->addChild('taikhoan');
            $newAccount->addAttribute('tentaikhoan', $username);
            $newAccount->addChild('matkhau', $password);
            $newAccount->addChild('loaitaikhoan', $accountType);
        }
    }

    $xml->asXML($xmlFilePath);
    return "Dữ liệu từ Excel đã được thêm vào XML thành công";
}

?>
