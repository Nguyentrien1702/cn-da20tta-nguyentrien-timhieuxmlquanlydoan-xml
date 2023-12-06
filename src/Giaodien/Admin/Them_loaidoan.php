<?php
    include("header-admin.php");
?>

<link rel="stylesheet" href="css/them-sua.css">

<?php
    $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
    $xml1 = simplexml_load_file($xmlFilePath1);

    // Kiểm tra xem có tham số truy vấn từ trang xử lý không
    if (isset($_GET["maloaidoan"], $_GET["tenloai"], $_GET["manganh"])) {
        // Nếu có, lấy giá trị từ tham số truy vấn
        $maloaidoan = $_GET["maloaidoan"];
        $tenloai = $_GET["tenloai"];
        $manganh = $_GET["manganh"];
    } else {
        // Nếu không, đặt giá trị mặc định hoặc để trống
        $maloaidoan = "";
        $tenloai = "";
    }
?>


<!-- Kích hoạt Select2 cho select -->
<script>

</script>

<?php
    include("footer-admin.php");
?>