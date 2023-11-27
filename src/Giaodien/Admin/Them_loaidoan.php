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

<div id="form">
    <h2 class="w3-container w3-red">Thêm Loại Đồ Án Mới</h2>

    <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_loaidoan.php" method="post">
        <label for="maloaidoan">Mã Loại Đồ Án:</label>
        <input class="w3-input w3-border" type="text" id="maloaidoan" name="txtmaloaidoan"
            value="<?php echo $maloaidoan; ?>" required>

        <label for="tenloai">Tên Loại Đồ Án:</label>
        <input class="w3-input w3-border" type="text" id="tenloai" name="txttenloai" value="<?php echo $tenloai; ?>" required>

        <label for="manganh">Mã Ngành:</label>
        <select class="w3-input w3-border select-search" id='manganh' name='txtmanganh' multiple='multiple'
            class="form-select" required>
            <?php
                $firstOption = true; // Dùng để đánh dấu phần tử đầu tiên
                    foreach ($xml1->nganh as $nganh){
                        if((string)$nganh['manganh'] == $_GET["manganh"]){
                            echo "<option selected value = " . $nganh['manganh'] . ">";
                            echo $nganh['manganh'] . " - " . $nganh->tennganh;
                            echo "</option>";
                        }
                        else{
                            echo "<option value = " . $nganh['manganh'] . ">";
                            echo $nganh['manganh'] . " - " . $nganh->tennganh;
                            echo "</option>";
                        }
                    }
                ?>
        </select>

        <button class='w3-btn w3-green' type='submit' name='sbmthem'>Thêm</button>
        <button class="w3-btn w3-red" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/loaidoan.php'">Hủy</button>
    </form>
</div>
<!-- Kích hoạt Select2 cho select -->
<script>
$(document).ready(function() {
    // Initialize Select2 with tags enabled
    $('.select-search').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function(params) {
            return undefined;
        },
        maximumSelectionLength: 1,
    });
});
</script>

<?php
    include("footer-admin.php");
?>