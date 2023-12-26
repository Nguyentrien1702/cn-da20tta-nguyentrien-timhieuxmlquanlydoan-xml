<?php
    include("header-admin.php");
?>
<title>Quản lý Loại Đề Tài</title>
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

.nhapexcel:hover {
    background-color: blue !important;
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
        if (isset($_GET["maloaidetai"]) && isset($_GET["tenloaidetai"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $maloaidetai = $_GET["maloaidetai"];
            $tenloaidetai = $_GET["tenloaidetai"];
            echo "<script>
                var form = document.getElementById('form');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
            </script>";
        }
        else if(isset($_GET["maloaidetai_sua"]) && isset($_GET["tenloaidetai"])){
            $maloaidetai = $_GET["maloaidetai_sua"];
            $tenloaidetai = $_GET["tenloaidetai"];
        }
            else {
                // Nếu không, đặt giá trị mặc định hoặc để trống
                $maloaidetai = "";
                $tenloaidetai = "";
            }
    ?>

<div class="w3-content">

    <div id="form" class="form-them-sua" style="display: none;">
        <h2 class="w3-container ten">Thêm Loại Đề Tài Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_loaidetai.php" method="post">
            <label for="maloaidetai">Mã Loại Đề Tài:</label>
            <input class="w3-input w3-border" type="text" id="maloaidetai" name="txtmaloaidetai" value="<?php echo $maloaidetai; ?>"
                required>

            <label for="tenloaidetai">Tên Loại Đề Tài:</label>
            <input class="w3-input w3-border" type="text" id="tenloaidetai" name="txttenloaidetai"
                value="<?php echo $tenloaidetai; ?>" required>

            <button class='w3-btn w3-green' type='submit' id="btnThem" name='sbmthem'>Thêm</button>
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/loaidetai.php'">Hủy</button>
        </form>
    </div>

    <div class="form-them-sua" id="form_sua" style="display: none;">
        <h2 class="w3-container ten">Sửa Loại Đề Tài</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_loaidetai.php" method="post">
            <label for="maloaidetai">Mã Loại Đề Tài:</label>
            <input class="w3-input w3-border" type="text" id="maloaidetai" name="txtmaloaidetai" value="<?php echo $maloaidetai; ?>"
                required readonly>

            <label for="tenloaidetai">Tên Loại Đề Tài:</label>
            <input class="w3-input w3-border" type="text" id="tenloaidetai" name="txttenloaidetai"
                value="<?php echo $tenloaidetai; ?>" required>

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat'>Cập nhật</button>
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/loaidetai.php'">Hủy</button>
        </form>
    </div>

    <h1 id="td">Danh sách Loại Đề Tài</h1>

    <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>

    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Mã Loại Đề Tài</th>
                <th class="table-header">Tên Loại Đề Tài</th>
                <th class="table-header">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $xmlFilePath = '../../QuanlyXML/Loaidetai.xml';
                    $xml = simplexml_load_file($xmlFilePath);
                    $i = 1;

                    foreach ($xml->loaidetai as $loaidetai) {
                        echo "<tr>";
                        echo "<td>". $i++ ."</td>";
                        echo "<td>{$loaidetai['maloaidetai']}</td>";
                        echo "<td>{$loaidetai->tenloaidetai}</td>";
                        $ma = $loaidetai['maloaidetai'];
                        $ten = $loaidetai->tenloaidetai;
                        echo "<td style='text-align: center;'>
                                <a id='sua' href='loaidetai.php?maloaidetai_sua=$ma&tenloaidetai=$ten' style = 'margin-right: 30px' >Sửa</a>"?>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa Loại Đề Tài này hay không?')" id='xoa'
                                    href="../../Xuly/Xuly_XML/Xuly_loaidetai.php?maloaidetai=<?php echo $ma ?>">Xóa</a></td>
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
    </script>
</div>
<?php
        // Kiểm tra xem có tham số truy vấn từ trang xử lý không
        if (isset($_GET["maloaidetai"]) && isset($_GET["tenloaidetai"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $maloaidetai = $_GET["maloaidetai"];
            $tenloaidetai = $_GET["tenloaidetai"];
            echo "<script>
                var form = document.getElementById('form');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

            </script>";
        }
        else if (isset($_GET["maloaidetai_sua"]) && isset($_GET["tenloaidetai"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $maloaidetai = $_GET["maloaidetai_sua"];
            $tenloaidetai = $_GET["tenloaidetai"];
            echo "<script>
                var form = document.getElementById('form_sua');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
            </script>";
        } else {
            // Nếu không, đặt giá trị mặc định hoặc để trống
            $maloaidetai = "";
            $tenloaidetai = "";
        }
    ?>
<?php

    include("footer-admin.php");
?>