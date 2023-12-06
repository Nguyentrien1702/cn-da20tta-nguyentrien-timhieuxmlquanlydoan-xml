<?php
    include("header-admin.php");

?>
    <title>Quản lý tài khoản</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <style>
        /* Định dạng màu cho bảng */
        #accountTable {
            background-color: #f0f0f0;
        }

        /* Định dạng cho các dòng tiêu đề */
        .table-header {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }

        /* Định dạng màu chữ cho nội dung */
        #accountTable td {
            color: #555;
        }

        /* Định dạng màu cho hàng chẵn */
        #accountTable tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        /* Định dạng màu cho hàng lẻ */
        #accountTable tr:nth-child(odd) {
            background-color: #f0f0f0;
        }
        div.dataTables_wrapper div.dataTables_filter {
        text-align: right; /* Align the search bar to the right */
        margin-bottom: 20px; /* Add some space between the search bar and the table */
        }
        h1 {
            text-align: center;
            font-weight: bold;
            color: red;
        }
    </style>


<div class="w3-content">
    <h1>Danh sách tài khoản</h1>

    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Tên tài khoản</th>
                <th class="table-header">Mật khẩu</th>
                <th class="table-header">Loại tài khoản</th>
                <th class="table-header">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $xmlFilePath = '../../QuanlyXML/Taikhoan.xml';
                $xml = simplexml_load_file($xmlFilePath);
                $i = 1;
                foreach ($xml->taikhoan as $taikhoan) {
                    if($taikhoan->loaitaikhoan != "Admin"){
                    echo "<tr>";
                    echo "<td>". $i++."</td>";
                    echo "<td>{$taikhoan['tentaikhoan']}</td>";
                    echo "<td>{$taikhoan->matkhau}</td>";
                    echo "<td>{$taikhoan->loaitaikhoan}</td>";
                    echo "<td style='text-align: center;'><a href='reset.php?username={$taikhoan['tentaikhoan']}'>Reset</a></td>";
                    echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>

    <script>
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
    include("footer-admin.php");

?>