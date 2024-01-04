<?php
  include("header-sinhvien.php")
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/them-sua.css">
<div style="text-align: center;">
  <h2 style="font-weight: bold; color: blue; margin-bottom: 30px">DANH SÁCH THÔNG TIN GIẢNG VIÊN</h2>
    <div class="custom-datatable-style" style="width: 80%; margin: auto;">
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style=" margin-top: 10px; margin: auto">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Tên giảng viên</th>
                <th class="table-header">Giới tính</th>
                <th class="table-header">Số điện thoại</th>
                <th class="table-header">Email</th>
                <th class="table-header">Phòng</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $xmlFilePath = '../../QuanlyXML/Giangvien.xml';
                    $xml = simplexml_load_file($xmlFilePath);
                    $i = 1;

                    foreach ($xml->giangvien as $giangvien) {
                        echo "<tr>";
                        echo "<td>". $i++ ."</td>";
                        echo "<td>{$giangvien->tengiangvien}</td>";
                        echo "<td>{$giangvien->gioitinh}</td>";
                        echo "<td>{$giangvien->sodienthoai}</td>";
                        echo "<td>{$giangvien->email}</td>";
                        echo "<td>{$giangvien->phong}</td>";
                        echo "</tr>";
                    }
                ?>
        </tbody>
    </table>
    </div>
</div>
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
  })
</Script>
<?php
  include("footer-sinhvien.php")
?>