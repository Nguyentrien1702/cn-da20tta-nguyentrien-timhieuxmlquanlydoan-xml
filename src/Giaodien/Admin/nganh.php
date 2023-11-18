<?php
    include("header-admin.php");
?>
    <title>Quản lý ngành</title>
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
        #themmoi {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        #themmoi:hover{
            background-color: blue !important;
        }
        #sua, #xoa{
            padding: 4px;
            background-color: cadetblue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        #sua:hover, #xoa:hover{
            background-color: #4CAF50;
        }

    </style>
    <div class="w3-content">
    <h1>Danh sách ngành</h1>
    
    <button id="themmoi" class="w3-button w3-green" onclick="location.href='Them_nganh.php'">Thêm mới</button>

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
                            <a id='sua' href='Sua_nganh.php?manganh_sua=$ma&tennganh=$ten' style = 'margin-right: 30px' >Sửa</a>"?>
                            <a onclick = "return confirm('Bạn có thật sự muốn xóa đề tài này hay không?')" id='xoa' href="../../Xuly/Xuly_XML/Xuly_nganh.php?manganh=<?php echo $ma ?>">Xóa</a></td>
            <?php
                    echo "</tr>";
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