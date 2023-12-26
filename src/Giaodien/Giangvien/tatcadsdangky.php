<?php
  include("header-giangvien.php");
  $user = $_SESSION["user"];
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<style>
    .mota {
    width: 15%;
    white-space: pre-line;
    margin-top: 0px;
    }
    td, th{
    vertical-align: middle !important;
}
</style>
<?php
    $xmlFilePath_dt = '../../QuanlyXML/Detai.xml';
    $xml_dt = simplexml_load_file($xmlFilePath_dt);
    $xmlFilePath_gv = '../../QuanlyXML/Giangvien.xml';
    $xml_gv = simplexml_load_file($xmlFilePath_gv);
    $xmlFilePath_n = '../../QuanlyXML/Nganh.xml';
    $xml_n = simplexml_load_file($xmlFilePath_n);
    $xmlFilePath_lda = '../../QuanlyXML/Loaidoan.xml';
    $xml_lda = simplexml_load_file($xmlFilePath_lda);
    $xmlFilePath_sv = '../../QuanlyXML/Sinhvien.xml';
    $xml_sv = simplexml_load_file($xmlFilePath_sv);
    $xmlFilePath_l = '../../QuanlyXML/Lop.xml';
    $xml_l = simplexml_load_file($xmlFilePath_l);
    $xmlFilePath_tg = '../../QuanlyXML/Thoigiantao_dangky.xml';
    $xml_tg = simplexml_load_file($xmlFilePath_tg);
    $xmlFilePath_dk = '../../QuanlyXML/Dangky.xml';
    $xml_dk = simplexml_load_file($xmlFilePath_dk);
?>
    <div class="div-content" style="width: 95%; margin:auto">
        <h1 style="text-align: center; color:blue; font-weight: bold; text-transform: uppercase;">Danh sách sinh viên đăng ký đề tài</h1>
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
                    <th class="table-header">Giảng viên hướng dẫn</th>
                    <th class="table-header">MSSV</th>
                    <th class="table-header">Họ tên SV</th>
                    <th class="table-header">Lớp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    $manganh = "";
                    $maloaidoan = "";
                    $namhoc = "";

                    foreach($xml_dk->dangky as $dangky){
                        echo "<tr>";
                            echo "<td>".$i++."</td>";
                            foreach($xml_dt->detai as $detai){
                                if((string)$detai["madetai"] == (string)$dangky->madetai){
                                    echo "<td class='mota'>{$detai->tendetai}</td>";
                                    echo "<td class='mota'>{$detai->mota}</td>";
                                    $maloaidoan = $detai->maloaidoan;
                                    $manganh = $detai->manganh;
                                    $namhoc = $detai->namhoc;
                                    break;
                                }                                    
                            }
                            foreach($xml_lda->loaidoan as $loaidoan){
                                if((string)$loaidoan['maloaidoan'] == $maloaidoan){
                                    echo "<td>{$loaidoan->tenloai}</td>";
                                    break;
                                }
                            }
                            foreach($xml_n->nganh as $nganh){
                                if((string)$nganh['manganh'] == $manganh){
                                    echo "<td>{$nganh->tennganh}</td>";
                                    echo "<td>{$namhoc}</td>";
                                }
                            }
                            foreach($xml_gv->giangvien as $giangvien){
                                if((string)$giangvien['msgv'] == (string)$dangky->msgv_hd){
                                    echo "<td>{$giangvien->tengiangvien}</td>";
                                }
                            }
                            foreach($xml_sv->sinhvien as $sinhvien){
                                if((string)$sinhvien['mssv'] == (string)$dangky->mssv){
                                    echo "<td>{$sinhvien['mssv']}</td>";
                                    echo "<td>{$sinhvien->tensinhvien}</td>";
                                    echo "<td>{$sinhvien->malop}</td>";
                                }
                            }

                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>
<Script>
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
</Script>
<?php
  include("footer-giangvien.php")
?>