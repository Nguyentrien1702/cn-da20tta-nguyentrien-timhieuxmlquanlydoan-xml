<?php
    include("header-admin.php");
?>
<title>Quản lý ngành</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/them-sua.css">
<style>
.custom-datatable-style #accountTable_wrapper {
    width: 100%;
    margin: 0 auto;
}
.form-them-sua {
    max-width: 600px;
    margin: 0 auto;
    margin-top: 40px;
    border-radius: 10px;
    /* Bo góc cho card */
    padding: 20px;
    /* Khoảng cách giữa nội dung và mép card */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    /* Đổ bóng cho card */
}

.nhapexcel {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.nhapexcel:hover {
    background-color: blue !important;
}
#div-content{
    width: 80%;
    margin: auto;
}
h1#td{
    text-transform:uppercase;
    font-weight: bolder;
    color:blue;
}
.ten{
    text-transform:uppercase;
    font-weight: bolder;
    color:blue;
    text-align: center;
}

</style>

<?php
        // Kiểm tra xem có tham số truy vấn từ trang xử lý không
        if (isset($_GET["msgv"], $_GET["tengiangvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["phong"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $msgv = $_GET["msgv"];
            $tengiangvien = $_GET["tengiangvien"];
            $gioitinh = $_GET["gioitinh"];
            $sodienthoai = $_GET["sodienthoai"];
            $email = $_GET["email"];
            $phong = $_GET["phong"];
        }
        else
            // Kiểm tra xem có tham số truy vấn từ trang xử lý không
            if (isset($_GET["msgv_sua"], $_GET["tengiangvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["phong"])) {
                // Nếu có, lấy giá trị từ tham số truy vấn
                $msgv = $_GET["msgv_sua"];
                $tengiangvien = $_GET["tengiangvien"];
                $gioitinh = $_GET["gioitinh"];
                $sodienthoai = $_GET["sodienthoai"];
                $email = $_GET["email"];
                $phong = $_GET["phong"];
            }
            else {
                // Nếu không, đặt giá trị mặc định hoặc để trống
                $msgv = "";
                $tengiangvien = "";
                $gioitinh = "";
                $sodienthoai = "";
                $email = "";
                $phong = "";

            }
    ?>
<div id="div-content">

    <!-- Form thêm giảng viên -->
    <div id="form" class="form-them-sua" style="display: none;">
        <h2 class="w3-container ten" >Thêm Giảng Viên Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_giangvien.php" method="post">
            <label for="msgv">Mã Số Giảng Viên:</label>
            <input class="w3-input w3-border" type="text" id="msgv" name="txtmsgv" value="<?php echo $msgv; ?>"
                required>

            <label for="tengiangvien">Tên Giảng Viên:</label>
            <input class="w3-input w3-border" type="text" id="tengiangvien" name="txttengiangvien"
                value="<?php echo $tengiangvien; ?>" required>

            <label>Giới Tính:</label>
            <label><input class="w3-radio w3-margin-left" type="radio" name="rdgioitinh" value="Nam" checked>
                Nam</label>
            <label><input class="w3-radio w3-margin-left" type="radio" name="rdgioitinh" value="Nữ"
                    <?php  if ($gioitinh == "Nữ") echo 'checked'; ?>> Nữ</label>
            <br><br>
            <label for="sodienthoai">Số Điện Thoại:</label>
            <input class="w3-input w3-border" type="text" id="sodienthoai" name="txtsodienthoai"
                value="<?php echo $sodienthoai; ?>">

            <label for="email">Email:</label>
            <input class="w3-input w3-border" type="text" id="email" name="txtemail" value="<?php echo $email; ?>">

            <label for="phong">Phòng:</label>
            <input class="w3-input w3-border" type="text" id="phong" name="txtphong" value="<?php echo $phong; ?>">

            <button class='w3-btn w3-green' type='submit' name='sbmthem'>Thêm</button>
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/giangvien.php'">Hủy</button>
        </form>
    </div>

    <!-- Form sửa giảng viên -->
    <div id="form_sua" class="form-them-sua" style="display: none;">
        <h2 class="w3-container ten" >Sửa Giảng Viên Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_giangvien.php" method="post">
            <label for="msgv">Mã Số Giảng Viên:</label>
            <input class="w3-input w3-border" type="text" id="msgv" name="txtmsgv" value="<?php echo $msgv; ?>"
                readonly>

            <label for="tengiangvien">Tên Giảng Viên:</label>
            <input class="w3-input w3-border" type="text" id="tengiangvien" name="txttengiangvien"
                value="<?php echo $tengiangvien; ?>" required>

            <label>Giới Tính:</label>
            <label><input class="w3-radio w3-margin-left" type="radio" name="rdgioitinh" value="Nam" checked>
                Nam</label>
            <label><input class="w3-radio w3-margin-left" type="radio" name="rdgioitinh" value="Nữ"
                    <?php  if ($gioitinh == "Nữ") echo 'checked'; ?>> Nữ</label>
            <br><br>
            <label for="sodienthoai">Số Điện Thoại:</label>
            <input class="w3-input w3-border" type="text" id="sodienthoai" name="txtsodienthoai"
                value="<?php echo $sodienthoai; ?>">

            <label for="email">Email:</label>
            <input class="w3-input w3-border" type="text" id="email" name="txtemail" value="<?php echo $email; ?>">

            <label for="phong">Phòng:</label>
            <input class="w3-input w3-border" type="text" id="phong" name="txtphong" value="<?php echo $phong; ?>">

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat'>Cập nhật</button>
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/giangvien.php'">Hủy</button>
        </form>
    </div>

    <div id="uploadModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom">
            <div class="w3-container" style="height: 200px;">
                <span onclick="closeModal()" class="w3-button w3-display-topright">&times;</span>
                <h2>Tải lên Tệp Excel</h2>

                <!-- Form để tải lên tệp Excel -->
                <form id="uploadForm" action="../../Xuly/Xuly_excel/Xuly_excel_giangvien.php" method="post"
                    enctype="multipart/form-data">
                    <label for="excelFile">Chọn Tệp Excel:</label>
                    <input type="file" id="excelFile" name="excelFile" accept=".xlsx, .xls" required>
                    <br>
                    <br>
                    <button type="submit" class="w3-button w3-green nhapexcel" name="nhap_excel">Tải lên</button>
                    <button type="button" onclick="closeModal()" class="w3-button w3-blue nhapexcel">Hủy</button>
                </form>
            </div>
        </div>
    </div>

    <h1 style="color: black" id="td">Danh sách Giảng viên</h1>

    <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>
    <button id="nhapexcel" onclick="openModal()" class="w3-button w3-green nhapexcel">Nhập File</button>
    <div class="custom-datatable-style">
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Mã giảng viên</th>
                <th class="table-header">Tên giảng viên</th>
                <th class="table-header">Giới tính</th>
                <th class="table-header">Số điện thoại</th>
                <th class="table-header">Email</th>
                <th class="table-header">Phòng</th>
                <th class="table-header">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $xmlFilePath = '../../QuanlyXML/Giangvien.xml';
                    $xml = simplexml_load_file($xmlFilePath);
                    $i = 1;

                    foreach ($xml->giangvien as $giangvien) {
                        echo "<tr>";
                        echo "<td>". $i++ ."</td>";
                        echo "<td>{$giangvien['msgv']}</td>";
                        echo "<td>{$giangvien->tengiangvien}</td>";
                        echo "<td>{$giangvien->gioitinh}</td>";
                        echo "<td>{$giangvien->sodienthoai}</td>";
                        echo "<td>{$giangvien->email}</td>";
                        echo "<td>{$giangvien->phong}</td>";

                        $msgv = $giangvien['msgv'];
                        $tengiangvien = $giangvien->tengiangvien;
                        $gioitinh = $giangvien->gioitinh;
                        $sodienthoai = $giangvien->sodienthoai;
                        $email = $giangvien->email;
                        $phong = $giangvien->phong;
                        echo "<td style='text-align: center;'>
                                <a id='sua' href='giangvien.php?msgv_sua=$msgv&tengiangvien=$tengiangvien&gioitinh=$gioitinh&sodienthoai=$sodienthoai&email=$email&phong=$phong' style = 'margin-right: 30px' >Sửa</a>"?>
            <a onclick="return confirm('Bạn có thật sự muốn xóa giảng viên này hay không?')" id='xoa'
                href="../../Xuly/Xuly_XML/Xuly_giangvien.php?msgv=<?php echo $msgv ?>">Xóa</a></td>
            <?php
                        echo "</tr>";
                    }
                ?>
        </tbody>
    </table>
    </div>
    <script>
    function toggleForm() {
        var form = document.getElementById('form');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';

        var themmoiBtn = document.getElementById('themmoi');
        themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

    }

    $(document).ready(function() {
        $('#accountTable').DataTable({
            paging: true,
            pageLength: 20, // Số dòng giới hạn của bảng
            searching: true, // Thanh tìm kiếm
            language: {
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                lengthMenu: "Hiển thị _MENU_ mục",
                search: "Tìm kiếm:",
                paginate: {
                    previous: "Trang trước",
                    next: "Trang tiếp theo",
                }
            }

        });
    });

    function openModal() {
        uploadButtonClicked = true;
        document.getElementById('uploadModal').style.display = 'block';
    }

    function closeModal() {
        uploadButtonClicked = false;
        document.getElementById('uploadModal').style.display = 'none';
    }
    </script>
</div>

    <?php
        // Kiểm tra xem có tham số truy vấn từ trang xử lý không
        if (isset($_GET["msgv"], $_GET["tengiangvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["phong"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $msgv = $_GET["msgv"];
            $tengiangvien = $_GET["tengiangvien"];
            $gioitinh = $_GET["gioitinh"];
            $sodienthoai = $_GET["sodienthoai"];
            $email = $_GET["email"];
            $phong = $_GET["phong"];
        
            echo "<script>
                var form = document.getElementById('form');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

            </script>";
        }
        else if (isset($_GET["msgv_sua"], $_GET["tengiangvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["phong"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $msgv_sua = $_GET["msgv_sua"];
            $tengiangvien = $_GET["tengiangvien"];
            $gioitinh = $_GET["gioitinh"];
            $sodienthoai = $_GET["sodienthoai"];
            $email = $_GET["email"];
            $phong = $_GET["phong"];
            echo "<script>
                var form = document.getElementById('form_sua');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
            </script>";
        } else {
            // Nếu không, đặt giá trị mặc định hoặc để trống
            $msgv = "";
            $tengiangvien = "";
            $gioitinh = "";
            $sodienthoai = "";
            $email = "";
            $phong = "";
        }
    ?>

<?php
    include("footer-admin.php");
?>