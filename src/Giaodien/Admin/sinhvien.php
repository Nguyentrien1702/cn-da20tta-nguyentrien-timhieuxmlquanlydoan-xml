<?php
    include("header-admin.php");
?>
<title>Quản lý ngành</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!--<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/them-sua.css">-->
<style>
.custom-datatable-style #accountTable_wrapper {
    width: 100%;
    margin: 0 auto;
}
.form-them-sua {
    max-width: 700px;
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

</style>

<?php
        $xmlFilePath1 = '../../QuanlyXML/Lop.xml';
        $xml1 = simplexml_load_file($xmlFilePath1);
        // Kiểm tra xem có tham số truy vấn từ trang xử lý không
        if (isset($_GET["mssv"], $_GET["tensinhvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["malop"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $mssv = $_GET["mssv"];
            $tensinhvien = $_GET["tensinhvien"];
            $gioitinh = $_GET["gioitinh"];
            $sodienthoai = $_GET["sodienthoai"];
            $email = $_GET["email"];
            $malop = $_GET["malop"];
        }
        else
            // Kiểm tra xem có tham số truy vấn từ trang xử lý không
            if (isset($_GET["mssv_sua"], $_GET["tensinhvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["malop"])) {
                // Nếu có, lấy giá trị từ tham số truy vấn
                $mssv = $_GET["mssv_sua"];
                $tensinhvien = $_GET["tensinhvien"];
                $gioitinh = $_GET["gioitinh"];
                $sodienthoai = $_GET["sodienthoai"];
                $email = $_GET["email"];
                $malop = $_GET["malop"];
            }
            else {
                // Nếu không, đặt giá trị mặc định hoặc để trống
                $mssv = "";
                $tensinhvien = "";
                $gioitinh = "";
                $sodienthoai = "";
                $email = "";
                $malop = "";

            }
    ?>
<div id="div-content">

    <!-- Form thêm Sinh viên -->
    <div id="form" class="form-them-sua" style="display: none;">
        <h2 class="w3-container">Thêm Sinh Viên Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_sinhvien.php" method="post">
            <label for="mssv">Mã Số Sinh Viên:</label>
            <input class="w3-input w3-border" type="text" id="mssv" name="txtmssv" value="<?php echo $mssv; ?>"
                required>

            <label for="tensinhvien">Tên Sinh Viên:</label>
            <input class="w3-input w3-border" type="text" id="tensinhvien" name="txttensinhvien"
                value="<?php echo $tensinhvien; ?>" required>

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

            </select>
            <label for="malop">Mã Lớp:</label>
            <select class="w3-input w3-border select-search" multiple="multiple" id='malop' name='txtmalop'
                class="form-select" required>
                <?php
                    foreach ($xml1->lop as $lop){
                        if((string)$lop['malop'] == $_GET["malop"]){
                            echo "<option selected value = " . $lop['malop'] . ">";
                            echo $lop['malop'] . " - " . $lop->tenlop. " khóa ".$lop->khoa;
                            echo "</option>";
                        }
                        else{
                            echo "<option value = " . $lop['malop'] . ">";
                            echo $lop['malop'] . " - " . $lop->tenlop. " khóa ".$lop->khoa;
                            echo "</option>";
                        }
                    }
                ?>
            </select>

            <button class='w3-btn w3-green' type='submit' name='sbmthem'>Thêm</button>
            <button class="w3-btn w3-red" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/sinhvien.php'">Hủy</button>
        </form>
    </div>

    <!-- Form sửa Sinh viên -->
    <div id="form_sua" class="form-them-sua" style="display: none;">
        <h2 class="w3-container">Sửa Sinh Viên Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_sinhvien.php" method="post">
            <label for="mssv">Mã Số Sinh Viên:</label>
            <input class="w3-input w3-border" type="text" id="mssv" name="txtmssv" value="<?php echo $mssv; ?>"
                readonly>

            <label for="tensinhvien">Tên Sinh Viên:</label>
            <input class="w3-input w3-border" type="text" id="tensinhvien" name="txttensinhvien"
                value="<?php echo $tensinhvien; ?>" required>

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

            </select>

            <label for="malop_sua">Mã Lớp:</label>
            <select class="w3-input w3-border select-search" multiple="multiple" id='malop_sua' name='txtmalop'
                class="form-select" required>
                <?php
                    foreach ($xml1->lop as $lop){
                        if((string)$lop['malop'] == $_GET["malop"]){
                            echo "<option selected value = " . $lop['malop'] . ">";
                            echo $lop['malop'] . " - " . $lop->tenlop. " khóa ".$lop->khoa;
                            echo "</option>";
                        }
                        else{
                            echo "<option value = " . $lop['malop'] . ">";
                            echo $lop['malop'] . " - " . $lop->tenlop. " khóa ".$lop->khoa;
                            echo "</option>";
                        }
                    }
                ?>
            </select>

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat'>Cập nhật</button>
            <button class="w3-btn w3-red" type="submit" name="sbmhuy"
            onclick="window.location.href='../../Giaodien/Admin/sinhvien.php'">Hủy</button>
        </form>
    </div>

    <div id="uploadModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom">
            <div class="w3-container" style="height: 200px;">
                <span onclick="closeModal()" class="w3-button w3-display-topright">&times;</span>
                <h2>Tải lên Tệp Excel</h2>

                <!-- Form để tải lên tệp Excel -->
                <form id="uploadForm" action="../../Xuly/Xuly_excel/Xuly_excel_sinhvien.php" method="post"
                    enctype="multipart/form-data">
                    <label for="excelFile">Chọn Tệp Excel:</label>
                    <input type="file" id="excelFile" name="excelFile" accept=".xlsx, .xls" required>
                    <br>
                    <br>
                    <button type="submit" class="w3-button w3-green nhapexcel" name="nhap_excel">Tải lên</button>
                    <button type="button" onclick="closeModal()" class="w3-button w3-red nhapexcel">Hủy</button>
                </form>
            </div>
        </div>
    </div>

    <h1 id = "td">Danh sách Sinh viên</h1>

    <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>
    <button id="nhapexcel" onclick="openModal()" class="w3-button w3-green nhapexcel">Nhập File</button>
    <div class="custom-datatable-style">
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Mã Sinh viên</th>
                <th class="table-header">Tên Sinh viên</th>
                <th class="table-header">Giới tính</th>
                <th class="table-header">Số điện thoại</th>
                <th class="table-header">Email</th>
                <th class="table-header">Mã Lớp</th>
                <th class="table-header">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $xmlFilePath = '../../QuanlyXML/Sinhvien.xml';
                    $xml = simplexml_load_file($xmlFilePath);
                    $i = 1;

                    foreach ($xml->sinhvien as $sinhvien) {
                        echo "<tr>";
                        echo "<td>". $i++ ."</td>";
                        echo "<td>{$sinhvien['mssv']}</td>";
                        echo "<td>{$sinhvien->tensinhvien}</td>";
                        echo "<td>{$sinhvien->gioitinh}</td>";
                        echo "<td>{$sinhvien->sodienthoai}</td>";
                        echo "<td>{$sinhvien->email}</td>";
                        echo "<td>{$sinhvien->malop}</td>";

                        $mssv = $sinhvien['mssv'];
                        $tensinhvien = $sinhvien->tensinhvien;
                        $gioitinh = $sinhvien->gioitinh;
                        $sodienthoai = $sinhvien->sodienthoai;
                        $email = $sinhvien->email;
                        $malop = $sinhvien->malop;
                        echo "<td style='text-align: center;'>
                                <a id='sua' href='sinhvien.php?mssv_sua=$mssv&tensinhvien=$tensinhvien&gioitinh=$gioitinh&sodienthoai=$sodienthoai&email=$email&malop=$malop' style = 'margin-right: 30px' >Sửa</a>"?>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa sinh viên này hay không?')" id='xoa'
                                    href="../../Xuly/Xuly_XML/Xuly_sinhvien.php?mssv=<?php echo $mssv ?>">Xóa</a></td>
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

        $('#malop').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                return undefined;
            },
            maximumSelectionLength: 1,
        });

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
        $('#malop').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                return undefined;
            },
            maximumSelectionLength: 1,
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
        if (isset($_GET["mssv"], $_GET["tensinhvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["malop"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $mssv = $_GET["mssv"];
            $tensinhvien = $_GET["tensinhvien"];
            $gioitinh = $_GET["gioitinh"];
            $sodienthoai = $_GET["sodienthoai"];
            $email = $_GET["email"];
            $malop = $_GET["malop"];
        
            echo "<script>
                var form = document.getElementById('form');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
                    $('#malop').select2({
                        tags: true,
                        tokenSeparators: [',', ' '],
                        createTag: function(params) {
                            return undefined;
                        },
                        maximumSelectionLength: 1,
                    });

            </script>";
        }
        else if (isset($_GET["mssv_sua"], $_GET["tensinhvien"], $_GET["gioitinh"], $_GET["sodienthoai"], $_GET["email"], $_GET["malop"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $mssv_sua = $_GET["mssv_sua"];
            $tensinhvien = $_GET["tensinhvien"];
            $gioitinh = $_GET["gioitinh"];
            $sodienthoai = $_GET["sodienthoai"];
            $email = $_GET["email"];
            $malop = $_GET["malop"];
            echo "<script>
                var form = document.getElementById('form_sua');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
                    $('#malop_sua').select2({
                        tags: true,
                        tokenSeparators: [',', ' '],
                        createTag: function(params) {
                            return undefined;
                        },
                        maximumSelectionLength: 1,
                    });
            </script>";
        } else {
            // Nếu không, đặt giá trị mặc định hoặc để trống
            $mssv = "";
            $tensinhvien = "";
            $gioitinh = "";
            $sodienthoai = "";
            $email = "";
            $malop = "";
        }
    ?>

<?php
    include("footer-admin.php");
?>