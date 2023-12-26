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
function kiemtra_thoigian(string $quyen, string $maloaidoan, string $nam){
    // Đường dẫn đến tài liệu XML
    $xmlFilePath_thoigian = '../QuanlyXML/Thoigiantao_dangky.xml';
    $xml_thoigian = simplexml_load_file($xmlFilePath_thoigian);
    foreach($xml_thoigian->thoigian as $thoigian ){
        if((string)$thoigian->quyen == $quyen && (string)$thoigian->maloaidoan == $maloaidoan && (string)$thoigian->namhoc == $nam){
            return true;
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
function updateThoigian($xmlFilePath, $matg, $ngaybatdau, $ngayketthuc) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Ngành
    foreach ($xml->thoigian as $thoigian) {
        if ((string)$thoigian['matg'] === $matg) {
            // Cập nhật Ngành
            $thoigian->ngaybatdau = $ngaybatdau;
            $thoigian->ngayketthuc = $ngayketthuc;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Ngành
            break;
        }
    }
}
function deleteThoigian($xmlFilePath, $matg) {
    $xml = simplexml_load_file($xmlFilePath);
    $thoigian = $xml->xpath("//thoigian[@matg='$matg']");

    unset($thoigian[0][0]);

    $xml->asXML($xmlFilePath);
}
function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
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
    $ktthoigian = kiemtra_thoigian($quyen, $maloaidoan, $namhoc);
    if($ktthoigian == true){
        myAlert("Đã tồn tại!", "../Giaodien/Admin/Giaodien_admin.php");
    }else{
        if($kiemtra == true){
            addThoigian($matg, $quyen ,$maloaidoan, $namhoc, $ngaybatdau, $ngayketthuc);
            myAlert("Thêm thành công!", "../Giaodien/Admin/Giaodien_admin.php");
        }else{
            addLoaidoan($maloaidoan, $manganh, $loaidoan);
            addThoigian($matg, $quyen ,$maloaidoan, $namhoc, $ngaybatdau, $ngayketthuc);
            myAlert("Thêm thành công!", "../Giaodien/Admin/Giaodien_admin.php");
        }
    }
}
if(isset($_POST["sbmcapnhat_thoigian"])){
    $matg = $_POST["matg_sua"];
    $ngaybatdau = $_POST["ngaybd_sua"];
    $ngayketthuc = $_POST["ngaykt_sua"];
    updateThoigian($xmlFilePath, $matg, $ngaybatdau, $ngayketthuc);
    myAlert("Đã cập nhật!", "../Giaodien/Admin/Giaodien_admin.php");
}
if(isset($_GET["matg_xoa"])){
    $matg_xoa = $_GET["matg_xoa"];
    deleteThoigian($xmlFilePath, $matg_xoa);
    header("Location: ../Giaodien/Admin/Giaodien_admin.php");
}

?>