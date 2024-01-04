<?php
    include("header-admin.php");
?>
<title>Quản lý lớp</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/them-sua.css">
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
        $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
        $xml1 = simplexml_load_file($xmlFilePath1);
        // Kiểm tra xem có tham số truy vấn từ trang xử lý không
        if (isset($_GET["malop"], $_GET["tenlop"], $_GET["khoa"], $_GET["manganh"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $malop = $_GET["malop"];
            $tenlop = $_GET["tenlop"];
            $khoa = $_GET["khoa"];
            $manganh = $_GET["manganh"];
        }
        else
            // Kiểm tra xem có tham số truy vấn từ trang xử lý không
            if (isset($_GET["malop_sua"], $_GET["tenlop"], $_GET["khoa"], $_GET["manganh"])) {
                // Nếu có, lấy giá trị từ tham số truy vấn
                $malop = $_GET["malop_sua"];
                $tenlop = $_GET["tenlop"];
                $khoa = $_GET["khoa"];
                $manganh = $_GET["manganh"];
            }
            else {
                // Nếu không, đặt giá trị mặc định hoặc để trống
                $malop = "";
                $tenlop = "";
                
            }
    ?>

<div class="w3-content">
    <!-- Form thêm lớp -->
    <div id="form" class="form-them-sua" style="display: none;">
        <h2 class="w3-container ten">Thêm Lớp Mới</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_lop.php" method="post">
            <label for="malop">Mã Lớp:</label>
            <input class="w3-input w3-border" type="text" id="malop" name="txtmalop" value="<?php echo $malop; ?>"
                required>

            <label for="tenlop">Tên Lớp:</label>
            <input class="w3-input w3-border" type="text" id="tenlop" name="txttenlop" value="<?php echo $tenlop; ?>"
                required>

            <label for="khoa">Khóa:</label>
            <select class="w3-input w3-border" name="txtkhoa" id="khoa">
                <?php
                // Lấy năm hiện tại
                $khoa = date("Y");

                // Tạo danh sách các năm trong vòng 10 năm lớn nhất
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
            <select class="w3-input w3-border" id='manganh' name='txtmanganh' multiple='multiple' class="form-select"
                required>
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
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/lop.php'">Hủy</button>


        </form>
    </div>

    <!-- Form sửa lớp -->
    <div id="form_sua"  class="form-them-sua" style="display: none;">
        <h2 class="w3-container ten">Cập nhật thông tin lớp</h2>

        <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_lop.php" method="post">
            <label for="malop">Mã Lớp:</label>
            <input class="w3-input w3-border" type="text" id="malop" name="txtmalop" value="<?php echo $malop; ?>"
                required readonly>

            <label for="tenlop">Tên Lớp:</label>
            <input class="w3-input w3-border" type="text" id="tenlop" name="txttenlop" value="<?php echo $tenlop; ?>"
                required>

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

            <label for="manganh_sua">Mã Ngành:</label>
            <select class="w3-input w3-border select-search" multiple="multiple" id='manganh_sua' name='txtmanganh'
                class="form-select" required>
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
            <button class="w3-btn w3-blue" type="submit" name="sbmhuy"
                onclick="window.location.href='../../Giaodien/Admin/lop.php'">Hủy</button>


        </form>
    </div>


    <h1 id="td">Danh sách lớp</h1>

    <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>

    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Mã lớp</th>
                <th class="table-header">Tên lớp</th>
                <th class="table-header">Ngành học</th>
                <th class="table-header">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $xmlFilePath = '../../QuanlyXML/Lop.xml';
                $xml = simplexml_load_file($xmlFilePath);

                $xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
                $xml1 = simplexml_load_file($xmlFilePath1);
                $i = 1;

                foreach ($xml->lop as $lop) {
                    echo "<tr>";
                    echo "<td>". $i++ ."</td>";
                    echo "<td>{$lop['malop']}</td>";
                    echo "<td>{$lop->tenlop} khóa {$lop->khoa}</td>";

                    foreach ($xml1->nganh as $nganh){
                        if((String)$lop->manganh == (String)$nganh['manganh']){
                            echo "<td>{$lop->manganh} - {$nganh->tennganh}</td>";
                            break;
                        }
                    }
                    
                    $ma = $lop['malop'];
                    
                    echo "<td style='text-align: center;'>
                            <a id='sua' href='lop.php?malop_sua={$lop['malop']}&tenlop={$lop->tenlop}&khoa={$lop->khoa}&manganh={$lop->manganh}' style = 'margin-right: 30px' >Sửa</a>"?>
            <a onclick="return confirm('Bạn có thật sự muốn xóa lớp này hay không?')" id='xoa'
                href="../../Xuly/Xuly_XML/Xuly_lop.php?malop=<?php echo $ma ?>">Xóa</a></td>
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
        if (isset($_GET["malop"], $_GET["tenlop"], $_GET["khoa"], $_GET["manganh"])) {
            // Nếu có, lấy giá trị từ tham số truy vấn
            $malop = $_GET["malop"];
            $tenlop = $_GET["tenlop"];
            $khoa = $_GET["khoa"];
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
        else
            // Kiểm tra xem có tham số truy vấn từ trang xử lý không
            if (isset($_GET["malop_sua"], $_GET["tenlop"], $_GET["khoa"], $_GET["manganh"])) {
                // Nếu có, lấy giá trị từ tham số truy vấn
                $malop = $_GET["malop_sua"];
                $tenlop = $_GET["tenlop"];
                $khoa = $_GET["khoa"];
                $manganh = $_GET["manganh"];
                echo "<script>
                    var form = document.getElementById('form_sua');
                        form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                    var themmoiBtn = document.getElementById('themmoi');
                        themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

                    $('#manganh_sua').select2({
                        tags: true,
                        tokenSeparators: [',', ' '],
                        createTag: function(params) {
                            return undefined;
                        },
                        maximumSelectionLength: 1,
                    });
                    </script>";
            }
            else {
                // Nếu không, đặt giá trị mặc định hoặc để trống
                $malop = "";
                $tenlop = "";
                
            }
    ?>

<?php
    include("footer-admin.php");
?>