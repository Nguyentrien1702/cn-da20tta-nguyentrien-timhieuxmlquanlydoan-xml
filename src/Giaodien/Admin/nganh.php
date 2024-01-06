<?php
    include("header-admin.php");
?>
<title>Quản lý ngành</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="css/them-sua.css">
<link rel="stylesheet" href="css/style.css">
<style>
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

.nhapexcel:hover {
    background-color: blue !important;
}
</style>
<?php
        // Kiểm tra xem có tham số truy vấn từ trang xử lý không
        if (isset($_GET["manganh"]) && isset($_GET["tennganh"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $manganh = $_GET["manganh"];
            $tennganh = $_GET["tennganh"];
            echo "<script>
                var form = document.getElementById('form');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
            </script>";
        }
        else if(isset($_GET["manganh_sua"]) && isset($_GET["tennganh"])){
            $manganh = $_GET["manganh_sua"];
            $tennganh = $_GET["tennganh"];
        }
            else {
                // Nếu không, đặt giá trị mặc định hoặc để trống
                $manganh = "";
                $tennganh = "";
            }
    ?>

<div class="w3-content">

    <div id="form" class="form-them-sua" style="display: none;">
        <h2 class="w3-container ten">Thêm Ngành Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_nganh.php" method="post">
            <label for="manganh">Mã Ngành:</label>
            <input class="w3-input w3-border" type="text" id="manganh" name="txtmanganh" value="<?php echo $manganh; ?>"
                required>

            <label for="tennganh">Tên Ngành:</label>
            <input class="w3-input w3-border" type="text" id="tennganh" name="txttennganh"
                value="<?php echo $tennganh; ?>" required>

            <button class='w3-btn w3-green' type='submit' id="btnThem" name='sbmthem'>Thêm</button>
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/nganh.php'">Hủy</button>
        </form>
    </div>

    <div class="form-them-sua" id="form_sua" style="display: none;">
        <h2 class="w3-container ten">Sửa ngành</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_nganh.php" method="post">
            <label for="manganh">Mã Ngành:</label>
            <input class="w3-input w3-border" type="text" id="manganh" name="txtmanganh" value="<?php echo $manganh; ?>"
                required readonly>

            <label for="tennganh">Tên Ngành:</label>
            <input class="w3-input w3-border" type="text" id="tennganh" name="txttennganh"
                value="<?php echo $tennganh; ?>" required>

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat'>Cập nhật</button>
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/nganh.php'">Hủy</button>
        </form>
    </div>

    <div id="uploadModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom">
            <div class="w3-container"  style="height: 200px;">
                <span onclick="closeModal()" class="w3-button w3-display-topright">&times;</span>
                <h2>Tải lên Tệp Excel</h2>

                <!-- Form để tải lên tệp Excel -->
                <form id="uploadForm" action="../../Xuly/Xuly_excel/Xuly_excel_nganh.php" method="post" enctype="multipart/form-data">
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

    <h1 id="td" style="margin-top: 80px !important;">Danh sách ngành</h1>

    <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>
    <button id="nhapexcel" onclick="openModal()" class="w3-button w3-green nhapexcel" style="display: none;">Nhập File</button>

    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Mã ngành</th>
                <th class="table-header">Tên ngành</th>
                <th class="table-header">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $xmlFilePath = '../../QuanlyXML/Nganh.xml';
                    $xml = simplexml_load_file($xmlFilePath);
                    $i = 1;

                    foreach ($xml->nganh as $nganh) {
                        echo "<tr>";
                        echo "<td>". $i++ ."</td>";
                        echo "<td>{$nganh['manganh']}</td>";
                        echo "<td>{$nganh->tennganh}</td>";
                        $ma = $nganh['manganh'];
                        $ten = $nganh->tennganh;
                        echo "<td style='text-align: center;'>
                                <a id='sua' href='nganh.php?manganh_sua=$ma&tennganh=$ten' style = 'margin-right: 30px' >Sửa</a>"?>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa ngành này hay không?')" id='xoa'
                                    href="../../Xuly/Xuly_XML/Xuly_nganh.php?manganh=<?php echo $ma ?>">Xóa</a></td>
            <?php
                        echo "</tr>";
                    }
            ?>
        </tbody>
    </table>

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
        if (isset($_GET["manganh"]) && isset($_GET["tennganh"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $manganh = $_GET["manganh"];
            $tennganh = $_GET["tennganh"];
            echo "<script>
                var form = document.getElementById('form');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

            </script>";
        }
        else if (isset($_GET["manganh_sua"]) && isset($_GET["tennganh"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $manganh = $_GET["manganh_sua"];
            $tennganh = $_GET["tennganh"];
            echo "<script>
                var form = document.getElementById('form_sua');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
            </script>";
        } else {
            // Nếu không, đặt giá trị mặc định hoặc để trống
            $manganh = "";
            $tennganh = "";
        }
    ?>
<?php

    include("footer-admin.php");
?>