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
<style>
    #div1{
        width: 95%;
        margin: auto;
    }
    h1#td{
        text-transform:uppercase;
        font-weight: bolder;
        color:blue;
        text-align: center;
    }
    .btnthem{
        margin-bottom: 10px;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        margin-right: 15px;
    }
    .btnthem:hover {
    background-color: blue !important;
    }

    #stt{
        width: 20px;
    }
    #trangthai{
        width: 5%;
    }
    th{
        text-align: center !important;
    }
    td, th{
    
    vertical-align: middle !important;
    }
    .mota {
    width: 20%;
    white-space: pre-line;
    margin-top: 0px;
    }
    .ten{
        text-transform:uppercase;
        font-weight: bolder;
        color:blue;
        text-align: center;
    }
    .btn{
        margin-top: 10px;
    }
    .ten{
        text-transform:uppercase;
        font-weight: bolder;
        color:blue;
        text-align: center;
    }
    #dangky{
        padding: 5px;
        background-color: blue;
        border-radius: 5px;
        color: white;
        text-decoration: none;
    }
    #dangky:hover{
        background-color: green;
    }
</style

<div id="div1">
<h1 id="td">Danh sách đề tài</h1>
    <div class="custom-datatable-style">
        <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
            <thead>
                <tr>
                    <th class="table-header" style="text-align: center;">STT</th>
                    <th class="table-header" style="text-align: center;">Tên đề tài</th>
                    <th class="table-header">Mô tả</th>
                    <th class="table-header">Loại đồ án</th>
                    <th class="table-header">Giảng viên</th>
                    <th class="table-header">Ngành</th>
                    <th class="table-header">Năm học</th>
                    <th class="table-header">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $xmlFilePath = '../../QuanlyXML/Detai.xml';
                $xml = simplexml_load_file($xmlFilePath);
                $xmlFilePath1 = '../../QuanlyXML/Giangvien.xml';
                $xml1 = simplexml_load_file($xmlFilePath1);
                $xmlFilePath2 = '../../QuanlyXML/Nganh.xml';
                $xml2 = simplexml_load_file($xmlFilePath2);
                $xmlFilePath3 = '../../QuanlyXML/Loaidoan.xml';
                $xml3 = simplexml_load_file($xmlFilePath3);
                $xmlFilePath4 = '../../QuanlyXML/Sinhvien.xml';
                $xml4 = simplexml_load_file($xmlFilePath4);
                $xmlFilePath5 = '../../QuanlyXML/Lop.xml';
                $xml5 = simplexml_load_file($xmlFilePath5);
                $xmlFilePath6 = '../../QuanlyXML/Thoigiantao_dangky.xml';
                $xml6 = simplexml_load_file($xmlFilePath6);
                $i = 1;
                $manganh = "";
                $namhoc = "";
                $dadangky = "0";
                $xmlFilePath_dk = '../../QuanlyXML/Dangky.xml';
                $xml_dk = simplexml_load_file($xmlFilePath_dk);
                $mssv = $_SESSION["user"];
                
                foreach($xml4->sinhvien as $sinhvien){
                    if($_SESSION["user"] == (string)$sinhvien["mssv"]){
                        foreach($xml5->lop as $lop){
                            if((string)$lop["malop"] == (string)$sinhvien->malop){
                                $manganh = $lop->manganh;
                                break;
                            }
                        }
                        break;
                    }
                }
                $dsmaloaidoan = [];
                foreach($xml6->thoigian as $thoigian){
                    if(($thoigian->ngaybatdau<= date("Y-m-d")) && ($thoigian->ngayketthuc >= date("Y-m-d"))){
                        if((string)$thoigian->quyen == "sinhvien"){                            
                            $ma =explode("-", $thoigian->maloaidoan);
                            $manganh_tg = end($ma);
                                                
                            if($manganh == $manganh_tg){                              
                                $namhoc = $thoigian->namhoc;
                                $dsmaloaidoan[] = $thoigian->maloaidoan;
                            }
                        }                        
                    }                    
                }
                foreach($xml_dk->dangky as $dangky){                            
                    if((string)$dangky->mssv == $mssv && (string)$dangky->namhoc == $namhoc){
                            $dadangky = "1";
                    }
                }
                $ktmadetai = "";
                foreach ($xml->detai as $detai) {
                    
                    if($detai->trangthaixetduyet == 1 && $manganh == (string)$detai->manganh && $namhoc == (string)$detai->namhoc ){
                        
                            if(in_array((string)$detai->maloaidoan, $dsmaloaidoan)){
                                echo "<tr>";
                                echo "<td id='stt'>".$i++."</td>";
                                echo "<td class='mota'>{$detai->tendetai}</td>";
                                echo "<td class='mota'>" . $detai->mota . "</td>";
                                $madetai = $detai["madetai"];
                                $manganhParts = explode('-', $detai->maloaidoan);
                                
                                // Lấy phần mã ngành đến trước dấu "-"
                                $manganhBeforeDash = trim($manganhParts[0]);
                                $manganhAfterDash = trim($manganhParts[1]);
                                echo "<td>";
                                foreach ($xml3->loaidoan as $loaidoan) {
                                    if((String)$detai->maloaidoan == (String)$loaidoan['maloaidoan']){
                                        echo "{$loaidoan->tenloai}";
                                        break;
                                    }
                                }
                                "</td>";
                                echo "<td>";
                                foreach ($xml1->giangvien as $giangvien) {
                                    if((String)$detai->msgv == (String)$giangvien['msgv']){
                                        echo "{$giangvien->tengiangvien}";
                                        break;
                                    }
                                }
                                "</td>";
                                                    
                                echo "<td>";
                                foreach ($xml2->nganh as $nganh) {
                                    if((String)$manganhAfterDash == (String)$nganh['manganh']){
                                        echo "{$nganh->tennganh}";
                                        break;
                                    }
                                }
                                "</td>";
                                echo "<td>{$detai->namhoc}</td>";
                                foreach($xml_dk->dangky as $dangky){
                                    if((string)$dangky->madetai== $madetai){
                                        $ktmadetai = "1";
                                    }
                                }
                                if($dadangky == "1"){
                                    echo "<td><i>Đã đóng</i></td>";
                                }
                                else{
                                    if($ktmadetai == "1"){                                    
                                        echo "<td><i>Đã đăng ký</i></td>";
                                        $ktmadetai = "";
                                    }
                                    else{
                                        echo "<td  style='text-align: center;'>
                                        <a id='dangky' href='../../Xuly/Xuly_XML/Xuly_themdangky.php?mssv_dk=$mssv&madetai=$madetai&msgv_hd={$detai->msgv}&namhoc=$namhoc'>Đăng ký</a>
                                        </td>";
                                    }                            
                                }
                                echo "</tr>";
                            }
                        
                        
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
<script>
    function toggleForm() {
        var form = document.getElementById('form');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';

        var themmoiBtn = document.getElementById('themmoi');
        themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

        $('#malop').select2({
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
        $('#malop').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                return undefined;
            },
            maximumSelectionLength: 1,
        });
    });

    function openModal() {
        uploadButtonClicked = true;
        document.getElementById('uploadModal').style.display = 'block';
    }

    function closeModal() {
        uploadButtonClicked = false;
        document.getElementById('uploadModal').style.display = 'none';
    }
    </script>
</div>
<?php
    include("footer-sinhvien.php")
?>