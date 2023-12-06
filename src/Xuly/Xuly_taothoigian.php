<?php
require '../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../QuanlyXML/Thoigiantao_dangky.xml';

function kiemtra_loaidoan(string $maloaidoan){
    // Đường dẫn đến tài liệu XML
    $xmlFilePath_loaidoan = '../QuanlyXML/Loaidoan.xml';
    $xml_loaidoan = simplexml_load_file($xmlFilePath_loaidoan);
    foreach($xml_loaidoan->loaidoan as $loaidoan ){
        if((string)$loaidoan['maloaidoan'] == $maloaidoan){
            return $loaidoan['maloaidoan'];
        }
    }
    return false;
}

function addLoaidoan($maloaidoan, $manganh, $loaidoan) {
    $xmlFilePath_loaidoan = '../QuanlyXML/Loaidoan.xml';
    $xml = simplexml_load_file($xmlFilePath_loaidoan);

    switch($loaidoan){
        case "CN":
            $tenloaidoan = "Đồ án chuyên ngành";
            break;
        case "CSN":
            $tenloaidoan = "Đồ án chuyên ngành";
            break;
        case "TT":
            $tenloaidoan = "Thực tập";
            break;
    }

    $newLoaidoan = $xml->addChild('loaidoan');
    $newLoaidoan->addAttribute('maloaidoan', $maloaidoan);
    $newLoaidoan->addChild('tenloai', $tenloaidoan);
    $newLoaidoan->addChild('manganh', $manganh);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath_loaidoan);
}

function addThoigian($matg, $quyen ,$maloaidoan, $namhoc, $ngaybatdau, $ngayketthuc) {
    $xmlFilePath_thoigian= '../QuanlyXML/Thoigiantao_dangky.xml';
    $xml = simplexml_load_file($xmlFilePath_thoigian);

    $newThoigian = $xml->addChild('thoigian');
    $newThoigian->addAttribute('matg', $matg);
    $newThoigian->addChild('quyen', $quyen);
    $newThoigian->addChild('maloaidoan', $maloaidoan);
    $newThoigian->addChild('namhoc', $namhoc);
    $newThoigian->addChild('ngaybatdau', $ngaybatdau);
    $newThoigian->addChild('ngayketthuc', $ngayketthuc);

    // Định dạng xuống dòng và thụt đầu dòng
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());

    // Lưu thay đổi vào tệp XML
    $dom->save($xmlFilePath_thoigian);
}

if(isset($_POST["sbmthem_thoigian"])){
    $matg = uniqid();
    $quyen = $_POST["txtquyen"];
    $loaidoan = $_POST["txtloaidoan"];
    $manganh = $_POST["txtmanganh"];
    $maloaidoan = $loaidoan."-".$manganh;
    $namhoc = $_POST["txtkhoa"];
    $ngaybatdau = $_POST["ngaybd"];
    $ngayketthuc = $_POST["ngaykt"];

    $kiemtra = kiemtra_loaidoan($maloaidoan);

    if($kiemtra == true){
        addThoigian($matg, $quyen ,$maloaidoan, $namhoc, $ngaybatdau, $ngayketthuc);
    }else{
        addLoaidoan($maloaidoan, $manganh, $loaidoan);
        addThoigian($matg, $quyen ,$maloaidoan, $namhoc, $ngaybatdau, $ngayketthuc);
    }


}

?>