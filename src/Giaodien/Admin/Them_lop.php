<?php
    include("header-admin.php");
?>
    <style>
        #formnganh {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 40px;
            border-radius: 10px; /* Bo góc cho card */
            padding: 20px; /* Khoảng cách giữa nội dung và mép card */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho card */
        }
        .w3-container-form {
            margin-bottom: 20px; /* Khoảng cách giữa header và form */
        }
        .w3-btn {
            margin-right: 10px;
            margin-bottom: 10px; /* Thêm khoảng cách dưới nút */
        }
        .w3-input {
            margin-bottom: 15px; /* Thêm khoảng cách dưới input */
        }
    </style>
<?php
    $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
    $xml1 = simplexml_load_file($xmlFilePath1);
    // Kiểm tra xem có tham số truy vấn từ trang xử lý không
    if (isset($_GET["malop"], $_GET["tenlop"], $_GET["manganh"])) {
        // Nếu có, lấy giá trị từ tham số truy vấn
        $malop = $_GET["malop"];
        $tenlop = $_GET["tenlop"];
        $manganh = $_GET["manganh"];
    } else {
        // Nếu không, đặt giá trị mặc định hoặc để trống
        $malop = "";
        $tenlop = "";
        
    }
?>
 
    <div id="formnganh">
        <h2 class="w3-container w3-red">Thêm Lớp Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_lop.php" method="post">
            <label for="malop">Mã Lớp:</label>
            <input class="w3-input w3-border" type="text" id="malop" name="txtmalop" value="<?php echo $malop; ?>" required >

            <label for="tenlop">Tên Lớp:</label>
            <input class="w3-input w3-border" type="text" id="tenlop" name="txttenlop" value="<?php echo $tenlop; ?>" required>

            <label for="manganh">Mã Ngành:</label>
            <select class="w3-input w3-border" id='manganh' name='txtmanganh' class="form-select" required>
                
                <?php
                    $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
                    $xml1 = simplexml_load_file($xmlFilePath1);

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
            <button class="w3-btn w3-red" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/lop.php'">Hủy</button>

            
        </form>
    </div>

<?php
    include("footer-admin.php");
?>