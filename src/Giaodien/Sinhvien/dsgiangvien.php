<?php
  include("header-sinhvien.php")
?>
<div style="text-align: center;">
  <h2 style="font-weight: bold; color: blue; margin-bottom: 30px">DANH SÁCH THÔNG TIN GIẢNG VIÊN</h2>
    <div class="custom-datatable-style">
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 80%; margin-top: 10px; margin: auto">
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
<?php
  include("footer-sinhvien.php")
?>