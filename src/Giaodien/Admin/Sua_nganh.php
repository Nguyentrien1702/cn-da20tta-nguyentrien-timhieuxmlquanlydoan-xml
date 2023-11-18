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

    if(isset($_GET["manganh_sua"]) && isset($_GET["tennganh"])){
        $manganh = $_GET["manganh_sua"];
        $tennganh = $_GET["tennganh"];
    }
?>
 
    <div id="formnganh">
        <h2 class="w3-container w3-red">Sửa ngành</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_nganh.php" method="post">
            <label for="manganh">Mã Ngành:</label>
            <input class="w3-input w3-border" type="text" id="manganh" name="txtmanganh" value="<?php echo $manganh; ?>" required readonly >

            <label for="tennganh">Tên Ngành:</label>
            <input class="w3-input w3-border" type="text" id="tennganh" name="txttennganh" value="<?php echo $tennganh; ?>" required>

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat'>Cập nhật</button>
            <button class="w3-btn w3-red" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/nganh.php'">Hủy</button>

            
        </form>
    </div>

<?php
    include("footer-admin.php");
?>