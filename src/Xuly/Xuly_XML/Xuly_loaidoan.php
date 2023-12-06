<?php
require '../../vendor/autoload.php'; // Đường dẫn đến autoload.php của Composer

// Đường dẫn đến tài liệu XML
$xmlFilePath = '../../QuanlyXML/Loaidoan.xml';

// Hàm kiểm tra xem Ngành có tồn tại hay không
function isLoaidoanExists($xmlFilePath, $maloaidoan) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->loaidoan as $loaidoan) {
        if ((string)$loaidoan['maloaidoan'] == $maloaidoan) {
            return true;
        }
    }
    return false;
}

// Hàm thêm Lớp mới
function addLoaidoan($xmlFilePath, $maloaidoan, $tenloaidoan, $manganh) {
    $xml = simplexml_load_file($xmlFilePath);

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
    $dom->save($xmlFilePath);
}

// Hàm cập nhật thông tin Ngành
function updateLoaidoan($xmlFilePath, $maloaidoan, $tenloaidoan, $manganh) {
    $xml = simplexml_load_file($xmlFilePath);
    // Tìm và cập nhật thông tin Ngành
    foreach ($xml->loaidoan as $loaidoan) {
        if ((string)$loaidoan['maloaidoan'] === $maloaidoan) {
            // Cập nhật Ngành
            $loaidoan->tenloaidoan = $tenloaidoan;
            $loaidoan->manganh = $manganh;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($xmlFilePath);

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Ngành
            break;
        }
    }
}

// Hàm xóa Ngành
function deleteLoaidoan($xmlFilePath, $maloaidoan) {
    $xml = simplexml_load_file($xmlFilePath);
    $loaidoan = $xml->xpath("//loaidoan[@maloaidoan='$maloaidoan']");

    unset($loaidoan[0][0]);

    $xml->asXML($xmlFilePath);
    
}

function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}

if(isset($_POST["sbmthem"])){

    $loaidoan = $_POST["txtloaidoan"];
    $tenloaidoan = "";
    switch ($loaidoan) {
        case "CSN":
            $tenloaidoan = "Đồ án cơ sở ngành";
            break;
        case "CN":
            $tenloaidoan = "Đồ án chuyên ngành";
            break;
        case "TT":
            $tenloaidoan = "Thực tập";
            break;
        // Thêm các trường hợp khác nếu cần
    }
    $manganh = $_POST["txtmanganh"];
    $maloaidoan = $loaidoan . "-" . $manganh;

    if(isLoaidoanExists($xmlFilePath, $maloaidoan)){
        myAlert("Mã ngành đã tồn tại","../../Giaodien/Admin/loaidoan.php?maloaidoan=$loaidoan&manganh=$manganh");
    }
    else{
        addLoaidoan($xmlFilePath, $maloaidoan, $tenloaidoan, $manganh);
        header("Location: ../../Giaodien/Admin/loaidoan.php");
    }
}
if(isset($_POST["sbmhuy"])){
    header("Location: ../../Giaodien/Admin/loaidoan.php");
}
if(isset($_POST["sbmcapnhat"])){
    $maloaidoan = $_POST["txtmaloaidoan"];
    $tenloaidoan = $_POST["txttenloaidoan"];
    $khoa = $_POST["txtkhoa"];
    $manganh = $_POST["txtmanganh"];
    updateLoaidoan($xmlFilePath, $maloaidoan, $tenloaidoan, $manganh);
    header("Location: ../../Giaodien/Admin/loaidoan.php");
}
if(isset($_GET["maloaidoan"])){
        $ma = $_GET["maloaidoan"];
        deleteLoaidoan($xmlFilePath, $ma);
        myAlert("Xóa thành công","../../Giaodien/Admin/loaidoan.php");
    }

?>
