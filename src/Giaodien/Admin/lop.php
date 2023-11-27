<?php
    include("header-admin.php");
?>
    <title>Quản lý ngành</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    
    <div class="w3-content">
    <h1>Danh sách lớp</h1>
    
    <button id="themmoi" class="w3-button w3-green" onclick="location.href='Them_lop.php'">Thêm mới</button>

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
                            <a id='sua' href='Sua_lop.php?malop_sua={$lop['malop']}&tenlop={$lop->tenlop}&khoa={$lop->khoa}&manganh={$lop->manganh}' style = 'margin-right: 30px' >Sửa</a>"?>
                            <a onclick = "return confirm('Bạn có thật sự muốn xóa lớp này hay không?')" id='xoa' href="../../Xuly/Xuly_XML/Xuly_lop.php?malop=<?php echo $ma ?>">Xóa</a></td>
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