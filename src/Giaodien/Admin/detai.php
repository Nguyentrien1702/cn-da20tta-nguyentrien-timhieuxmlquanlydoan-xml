<?php
  include("header-admin.php")
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<style>
.mota {
    width: 20%;
    white-space: pre-line;
    margin-top: 0px;
    text-align: left !important;
}

#div-content {
    width: 95%;
    margin: auto;
}

h1 {
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 80px !important;
}

td, th{
    text-align: center !important;
    vertical-align: middle !important;
}
</style>
<div id="div-content">
    <h1>Danh sách đề tài</h1>
    <div class="custom-datatable-style">
        <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
            <thead>
                <tr>
                    <th class="table-header">STT</th>
                    <th class="table-header">Tên đề tài</th>
                    <th class="table-header">Mô tả</th>
                    <th class="table-header">Loại đồ án</th>
                    <th class="table-header">Ngành</th>
                    <th class="table-header">Năm học</th>
                    <th class="table-header">Giảng viên ra đề tài</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $xmlFilePath = '../../QuanlyXML/Detai.xml';
                    $xml = simplexml_load_file($xmlFilePath);
                    $xmlFilePath_loaidoan = '../../QuanlyXML/Loaidoan.xml';
                    $xml_loaidoan = simplexml_load_file($xmlFilePath_loaidoan);
                    $xmlFilePath_nganh = '../../QuanlyXML/Nganh.xml';
                    $xml_nganh = simplexml_load_file($xmlFilePath_nganh);
                    $xmlFilePath_giangvien = '../../QuanlyXML/Giangvien.xml';
                    $xml_giangvien = simplexml_load_file($xmlFilePath_giangvien);
                    $i = 1;

                    foreach ($xml->detai as $detai) {
                        if($detai->trangthaixetduyet == 1){
                        echo "<tr>";
                        echo "<td>". $i++ ."</td>";
                        echo "<td class='mota'>{$detai->tendetai}</td>";
                        echo "<td class='mota'>{$detai->mota}</td>";
                        foreach ($xml_loaidoan->loaidoan as $loaidoan) {
                            if((string)$loaidoan['maloaidoan'] == (string)$detai->maloaidoan){
                              echo "<td>".$loaidoan->tenloai."</td>";
                              break;
                            }
                          }

                        foreach ($xml_nganh->nganh as $nganh) {
                            if((string)$nganh['manganh'] == (string)$detai->manganh){
                              echo "<td>".$nganh->tennganh."</td>";
                              break;
                            }
                        }

                        echo "<td>{$detai->namhoc}</td>";
                        foreach ($xml_giangvien->giangvien as $giangvien) {
                            if((string)$giangvien['msgv'] == (string)$detai->msgv){
                              echo "<td>".$giangvien->tengiangvien."</td>";
                              break;
                            }
                        }
                        echo "</tr>";}
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
});

</script>

<?php
  include("footer-admin.php")
?>