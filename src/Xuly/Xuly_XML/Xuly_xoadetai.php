<?php    
    require_once 'Xuly_detai.php'; // Đường dẫn đến file chứa các hàm xử lý với đề tài
    if(isset($_GET["maxoa"])){
        $xmlFilePath = '../../QuanlyXML/Detai.xml';
        $maxoa = $_GET["maxoa"];
        deleteDetai($xmlFilePath, $maxoa);
        myAlert("Xóa thành công","../../Giaodien/Giangvien/detaicanhan.php");
    }
    if(isset($_POST["sbmcapnhat_detai"])){
        $xmlFilePath = '../../QuanlyXML/Detai.xml';
        $madetai = $_POST["madetai_sua"];
        $trangthai = $_POST["trangthai"];
        $tendetai = $_POST["tendetai"];
        $mota = $_POST["mota_sua"];
        if($trangthai == "2"){
            updateDetaighichu($xmlFilePath, $madetai, "0", "");
            updateDetaimota($xmlFilePath, $madetai, $tendetai, $mota);
        }else{
            updateDetaimota($xmlFilePath, $madetai, $tendetai, $mota);
        }
        myAlert("Cập nhật thành công","../../Giaodien/Giangvien/detaicanhan.php");
    }
?>