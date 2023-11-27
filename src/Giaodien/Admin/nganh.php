<?php
    include("header-admin.php");
?>
    <title>Quản lý ngành</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
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
            <h2 class="w3-container w3-red">Thêm Ngành Mới</h2>

            <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_nganh.php" method="post">
                <label for="manganh">Mã Ngành:</label>
                <input class="w3-input w3-border" type="text" id="manganh" name="txtmanganh" value="<?php echo $manganh; ?>" required >

                <label for="tennganh">Tên Ngành:</label>
                <input class="w3-input w3-border" type="text" id="tennganh" name="txttennganh" value="<?php echo $tennganh; ?>" required>

                <button class='w3-btn w3-green' type='submit' id="btnThem" name='sbmthem'>Thêm</button>
                <button class="w3-btn w3-red" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/nganh.php'">Hủy</button> 
            </form>
        </div>

        <div class="form-them-sua" id="form_sua" style="display: none;">
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

        <h1>Danh sách ngành</h1>
        
        <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>

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
                                <a onclick = "return confirm('Bạn có thật sự muốn xóa ngành này hay không?')" id='xoa' href="../../Xuly/Xuly_XML/Xuly_nganh.php?manganh=<?php echo $ma ?>">Xóa</a></td>
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