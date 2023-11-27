<?php
    include("header-admin.php");
?>
    <link rel="stylesheet" href="css/them-sua.css">
<?php
    $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
    $xml1 = simplexml_load_file($xmlFilePath1);
    // Kiểm tra xem có tham số truy vấn từ trang xử lý không
    if (isset($_GET["malop_sua"], $_GET["tenlop"], $_GET["khoa"], $_GET["manganh"])) {
        // Nếu có, lấy giá trị từ tham số truy vấn
        $malop = $_GET["malop_sua"];
        $tenlop = $_GET["tenlop"];
        $khoa = $_GET["khoa"];
        $manganh = $_GET["manganh"];
    } else {
        // Nếu không, đặt giá trị mặc định hoặc để trống
        $malop = "";
        $tenlop = "";
        
    }
?>
 
    <div id="form">
        <h2 class="w3-container w3-red">Thêm Lớp Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_lop.php" method="post">
            <label for="malop">Mã Lớp:</label>
            <input class="w3-input w3-border" type="text" id="malop" name="txtmalop" value="<?php echo $malop; ?>" required readonly>

            <label for="tenlop">Tên Lớp:</label>
            <input class="w3-input w3-border" type="text" id="tenlop" name="txttenlop" value="<?php echo $tenlop; ?>" required>
            
            <label for="khoa">Khóa:</label>
            <select class="w3-input w3-border" name="txtkhoa" id="khoa">
                <?php
                // Lấy năm hiện tại
                $khoa = date("Y");

                // Tạo danh sách các năm trong vòng 10 năm
                for ($i = $khoa; $i >= $khoa - 9; $i--) {
                    if($i == $_GET["khoa"]){
                        echo "<option selected value = " . $_GET['khoa'] . ">";
                        echo "{$_GET['khoa']}";
                        echo "</option>";
                    }else{
                        echo "<option value='$i'>$i</option>";
                    }
                }
                ?>
            </select>

            <label for="manganh">Mã Ngành:</label>
            <select class="w3-input w3-border select-search" multiple="multiple" id='manganh' name='txtmanganh' class="form-select" required>
                <?php
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

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat'>Cập nhật</button>
            <button class="w3-btn w3-red" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/lop.php'">Hủy</button>

            
        </form>
    </div>

    <script>
    $(document).ready(function() {
        // Initialize Select2 with tags enabled
        $('.select-search').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function (params) {
                return undefined;
            },
            maximumSelectionLength: 1,
        });
    });
</script>

<?php
    include("footer-admin.php");
?>