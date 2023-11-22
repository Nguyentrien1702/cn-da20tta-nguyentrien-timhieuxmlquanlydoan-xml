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

    // Kiểm tra xem có tham số truy vấn từ trang xử lý không
    if (isset($_GET["mahk-nk_sua"], $_GET["tenhocky"], $_GET["nienkhoa"], $_GET["ngaybatdau"], $_GET["ngayketthuc"])) {
        // Nếu có, lấy giá trị từ tham số truy vấn
        $mahknk = $_GET["mahk-nk_sua"];
        $tenhocky = $_GET["tenhocky"];
        $nienkhoa = $_GET["nienkhoa"];
        $ngaybatdau = date('Y-m-d', strtotime($_GET["ngaybatdau"]));
        $ngayketthuc = date('Y-m-d', strtotime($_GET["ngayketthuc"]));
    } else {
        // Nếu không, đặt giá trị mặc định hoặc để trống
        $mahknk = "";
        $tenhocky = "";
        $nienkhoa = "";
        $ngaybatdau = date('Y-m-d');
        $ngayketthuc = date('Y-m-d', strtotime($ngaybatdau . ' +1 month'));
    }
?>
 
    <div id="formnganh">
        <h2 class="w3-container w3-red">Sửa Học kỳ</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_hocky.php" method="post">
            <label for="mahk-nk">Mã Học kỳ:</label>
            <input class="w3-input w3-border" type="text" id="mahk-nk" name="txtmahk-nk" value="<?php echo $mahknk; ?>" required readonly>

            <label for="tenhocky">Tên Học Kỳ:</label>
            <input class="w3-input w3-border" type="text" id="tenhocky" name="txttenhocky" value="<?php echo $tenhocky; ?>" required>

            <label for="nienkhoa">Niên Khóa:</label>
            <input class="w3-input w3-border" type="text" id="nienkhoa" name="txtnienkhoa" value="<?php echo $nienkhoa; ?>" required>

            <label for="ngaybatdau">Ngày Bắt Đầu:</label>
            <input class="w3-input w3-border" type="date" id="ngaybatdau" name="dtngaybatdau" value="<?php echo $ngaybatdau; ?>" required>

            <label for="ngayketthuc">Ngày Kết Thúc:</label>
            <input class="w3-input w3-border" type="date" id="ngayketthuc" name="dtngayketthuc" value="<?php echo $ngayketthuc; ?>" required>

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat'>Cập nhật</button>
            <button class="w3-btn w3-red" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/hocky.php'">Hủy</button>

            
        </form>
    </div>

<?php
    include("footer-admin.php");
?>