<?php
include("header-admin.php");
?>

<title>Quản lý ngành</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<link rel="stylesheet" href="css/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<link rel="stylesheet" href="css/them-sua.css">

<?php
    $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
    $xml1 = simplexml_load_file($xmlFilePath1);

    // Kiểm tra xem có tham số truy vấn từ trang xử lý không
    if (isset($_GET["maloaidoan"], $_GET["manganh"])) {
        // Nếu có, lấy giá trị từ tham số truy vấn
        $maloaidoan = $_GET["maloaidoan"];
        $manganh = $_GET["manganh"];
    } else {
        // Nếu không, đặt giá trị mặc định hoặc để trống
        $maloaidoan = "";
    }
?>

<div class="w3-content">
    <div id="form" class="form-them-sua" style="display: none;">
        <h2 class="w3-container w3-red">Thêm Loại Đồ Án Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_loaidoan.php" method="post">
            <label for="loaidoan">Loại đồ án:</label>
            <select class="w3-input w3-border" id='loaidoan' name='txtloaidoan' required>
                <option value="CSN" <?php  if ($maloaidoan == "CSN") echo 'selected'; ?>>Đồ án cơ sở ngành</option>
                <option value="CN" <?php if ($maloaidoan == "CN") echo 'selected'; ?>>Đồ án chuyên ngành</option>
                <option value="TT" <?php if ($maloaidoan == "TT") echo 'selected'; ?>>Thực tập</option>
            </select>

            <label for="manganh"> Ngành Học:</label>
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
            <button class="w3-btn w3-red" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/loaidoan.php'">Hủy</button>
        </form>
    </div>

    <h1>Danh sách loại đồ án</h1>

    <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>

    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Mã đồ án</th>
                <th class="table-header">Tên đồ án</th>
                <th class="table-header">Ngành học</th>
                <!-- <th class="table-header">Thao tác</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $xmlFilePath = '../../QuanlyXML/Loaidoan.xml';
            $xml = simplexml_load_file($xmlFilePath);

            $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
            $xml1 = simplexml_load_file($xmlFilePath1);
            $i = 1;

            foreach ($xml->loaidoan as $loaidoan) {
                echo "<tr>";
                echo "<td>" . $i++ . "</td>";
                echo "<td>{$loaidoan['maloaidoan']}</td>";
                echo "<td>{$loaidoan->tenloai}</td>";

                foreach ($xml1->nganh as $nganh) {
                    if ((string)$loaidoan->manganh == (string)$nganh['manganh']) {
                        echo "<td>{$loaidoan->manganh} - {$nganh->tennganh}</td>";
                        break;
                    }
                }

                // $ma = $loaidoan['maloaidoan'];

                // echo "<td style='text-align: center;'>
                //         <a id='sua' href='Sua_lop.php?maloaidoan_sua={$loaidoan['maloaidoan']}&tenloai={$loaidoan->tenloai}&manganh={$loaidoan->manganh}' style='margin-right: 30px'>Sửa</a>";
                // echo "<a onclick='return confirm(\"Bạn có thật sự muốn xóa lớp này hay không?\")' id='xoa' href='../../Xuly/Xuly_XML/Xuly_lop.php?maloaidoan={$ma}'>Xóa</a></td>";
                // echo "</tr>";
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

        $('#manganh').select2({
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
            pageLength: 20,
            searching: true,
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
    $(document).ready(function() {
        // Initialize Select2 with tags enabled
        $('#manganh').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                return undefined;
            },
            maximumSelectionLength: 1,
        });
    });
    </script>
</div>

<?php
        $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
            $xml1 = simplexml_load_file($xmlFilePath1);

        // Kiểm tra xem có tham số truy vấn từ trang xử lý không
        if (isset($_GET["maloaidoan"], $_GET["manganh"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $maloaidoan = $_GET["maloaidoan"];
            $manganh = $_GET["manganh"];
            
            echo "<script>
                var form = document.getElementById('form');
                    form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                var themmoiBtn = document.getElementById('themmoi');
                    themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';
                    $('#manganh').select2({
                        tags: true,
                        tokenSeparators: [',', ' '],
                        createTag: function(params) {
                            return undefined;
                        },
                        maximumSelectionLength: 1,
                    });
            </script>";
        }
    ?>

<?php
include("footer-admin.php");
?>