    <?php
        include("header-admin.php");
    ?>
        <title>Quản lý ngành</title>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/them-sua.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
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

        <div class="w3-content">

        <?php
            // Kiểm tra xem có tham số truy vấn từ trang xử lý không
            if (isset($_GET["mahk-nk"], $_GET["tenhocky"], $_GET["nienkhoa"], $_GET["ngaybatdau"], $_GET["ngayketthuc"])) {
                // Nếu có, lấy giá trị từ tham số truy vấn
                $mahknk = $_GET["mahk-nk"];
                $tenhocky = $_GET["tenhocky"];
                $nienkhoa = $_GET["nienkhoa"];
                $ngaybatdau = $_GET["ngaybatdau"];
                $ngayketthuc = $_GET["ngayketthuc"];
            }
            else 
                // Kiểm tra xem có tham số truy vấn từ trang xử lý không
                if (isset($_GET["mahk-nk_sua"], $_GET["tenhocky"], $_GET["nienkhoa"], $_GET["ngaybatdau"], $_GET["ngayketthuc"])) {
                    // Nếu có, lấy giá trị từ tham số truy vấn
                    $mahknk = $_GET["mahk-nk_sua"];
                    $tenhocky = $_GET["tenhocky"];
                    $nienkhoa = $_GET["nienkhoa"];
                    $ngaybatdau = date('Y-m-d', strtotime($_GET["ngaybatdau"]));
                    $ngayketthuc = date('Y-m-d', strtotime($_GET["ngayketthuc"]));
                }
                else {
                    // Nếu không, đặt giá trị mặc định hoặc để trống
                    $mahknk = "";
                    $tenhocky = "";
                    $nienkhoa = "";
                    $ngaybatdau = date('Y-m-d');
                    $ngayketthuc = date('Y-m-d', strtotime($ngaybatdau . ' +1 month'));
                }
        ?>
        <!-- Form thêm học kỳ -->
        <div id="form" class="form-them-sua" style="display: none;">
            <h2 class="w3-container ten">Thêm Học kỳ Mới</h2>

            <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_hocky.php" method="post">
                <label for="mahk-nk">Mã Học kỳ:</label>
                <input class="w3-input w3-border" type="text" id="mahk-nk" name="txtmahk-nk" value="<?php echo $mahknk; ?>" required >

                <label for="tenhocky">Tên Học Kỳ:</label>
                <input class="w3-input w3-border" type="text" id="tenhocky" name="txttenhocky" value="<?php echo $tenhocky; ?>" required>

                <label for="nienkhoa">Niên Khóa:</label>
                <input class="w3-input w3-border" type="text" id="nienkhoa" name="txtnienkhoa" value="<?php echo $nienkhoa; ?>" required>

                <label for="ngaybatdau">Ngày Bắt Đầu:</label>
                <input class="w3-input w3-border" type="date" id="ngaybatdau" name="dtngaybatdau" value="<?php echo $ngaybatdau; ?>" required>

                <label for="ngayketthuc">Ngày Kết Thúc:</label>
                <input class="w3-input w3-border" type="date" id="ngayketthuc" name="dtngayketthuc" value="<?php echo $ngayketthuc; ?>" required>

                <button class='w3-btn w3-green' type='submit' name='sbmthem'>Thêm</button>
                <button class="w3-btn w3-blue" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/hocky.php'">Hủy</button>         
            </form>
        </div>

        <!-- Form sửa học kỳ -->
        <div id="form_sua" class="form-them-sua" style="display: none;">
            <h2 class="w3-container ten">Sửa Học kỳ</h2>

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
                <button class="w3-btn w3-blue" type="submit" name="sbmhuy" onclick="window.location.href='../../Giaodien/Admin/hocky.php'">Hủy</button>

                
            </form>
        </div>

        <h1 id="td">Danh sách học kỳ</h1>
        
        <button id="themmoi" class="w3-button w3-green" onclick="toggleForm()">Thêm mới</button>

        <table id="hockyTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
            <thead>
                <tr>
                    <th class="table-header">STT</th>
                    <th class="table-header">Mã học kỳ - niên khóa</th>
                    <th class="table-header">Tên học kỳ</th>
                    <th class="table-header">Niên khóa</th>
                    <th class="table-header">Ngày bắt đầu</th>
                    <th class="table-header">Ngày kết thúc</th>
                    <th class="table-header">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $xmlFilePath = '../../QuanlyXML/Hocky.xml';
                    $xml = simplexml_load_file($xmlFilePath);
                    $i = 1;

                    foreach ($xml->hocky as $hocky) {
                        echo "<tr>";
                        echo "<td>". $i++ ."</td>";
                        echo "<td>{$hocky['mahk-nk']}</td>";
                        echo "<td>{$hocky->tenhocky}</td>";
                        echo "<td>{$hocky->nienkhoa}</td>";
                        echo "<td>". date('d-m-Y', strtotime($hocky->ngaybatdau)) ."</td>";
                        echo "<td>". date('d-m-Y', strtotime($hocky->ngayketthuc)) ."</td>";

                        // $ma = $nganh['manganh'];
                        // $ten = $nganh->tennganh;
                        echo "<td style='text-align: center;'>
                                <a id='sua' href='hocky.php?mahk-nk_sua={$hocky['mahk-nk']}&tenhocky={$hocky->tenhocky}&nienkhoa={$hocky->nienkhoa}&ngaybatdau={$hocky->ngaybatdau}&ngayketthuc={$hocky->ngayketthuc}'
                                style = 'margin-right: 30px' >Sửa</a>"?>
                                <a onclick = "return confirm('Bạn có thật sự muốn xóa học kỳ này hay không?')" id='xoa' href="../../Xuly/Xuly_XML/Xuly_hocky.php?mahk-nk=<?php echo "{$hocky['mahk-nk']}" ?>">Xóa</a></td>
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
                $('#hockyTable').DataTable({
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
                    },
                    columns: [
                        null, // STT
                        null, // Mã học kỳ - niên khóa
                        null, // Tên học kỳ
                        null, // Niên khóa
                        { "type": "date-euro" }, // Ngày bắt đầu
                        { "type": "date-euro" }, // Ngày kết thúc
                        null // Thao tác
                    ]
                    
                });
            });
        </script>
    </div>

    <?php
            // Kiểm tra xem có tham số truy vấn từ trang xử lý không
            if (isset($_GET["mahk-nk"], $_GET["tenhocky"], $_GET["nienkhoa"], $_GET["ngaybatdau"], $_GET["ngayketthuc"])) {
                // Nếu có, lấy giá trị từ tham số truy vấn
                $mahknk = $_GET["mahk-nk"];
                $tenhocky = $_GET["tenhocky"];
                $nienkhoa = $_GET["nienkhoa"];
                $ngaybatdau = $_GET["ngaybatdau"];
                $ngayketthuc = $_GET["ngayketthuc"];
                echo "<script>
                    var form = document.getElementById('form');
                        form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                    var themmoiBtn = document.getElementById('themmoi');
                        themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

                </script>";
            }
            else 
                // Kiểm tra xem có tham số truy vấn từ trang xử lý không
                if (isset($_GET["mahk-nk_sua"], $_GET["tenhocky"], $_GET["nienkhoa"], $_GET["ngaybatdau"], $_GET["ngayketthuc"])) {
                    // Nếu có, lấy giá trị từ tham số truy vấn
                    $mahknk = $_GET["mahk-nk_sua"];
                    $tenhocky = $_GET["tenhocky"];
                    $nienkhoa = $_GET["nienkhoa"];
                    $ngaybatdau = date('Y-m-d', strtotime($_GET["ngaybatdau"]));
                    $ngayketthuc = date('Y-m-d', strtotime($_GET["ngayketthuc"]));
                    echo "<script>
                        var form = document.getElementById('form_sua');
                            form.style.display = (form.style.display === 'none') ? 'block' : 'none';

                        var themmoiBtn = document.getElementById('themmoi');
                            themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

                    </script>";
                }
                else {
                    // Nếu không, đặt giá trị mặc định hoặc để trống
                    $mahknk = "";
                    $tenhocky = "";
                    $nienkhoa = "";
                    $ngaybatdau = date('Y-m-d');
                    $ngayketthuc = date('Y-m-d', strtotime($ngaybatdau . ' +1 month'));
                }
        ?>
        
    <?php
        include("footer-admin.php");
    ?>