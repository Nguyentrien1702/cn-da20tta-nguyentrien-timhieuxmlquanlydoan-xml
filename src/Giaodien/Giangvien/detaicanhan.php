<?php
    include("header-giangvien.php")
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
    td, th{
    
    vertical-align: middle !important;
    }
    .mota {
        width: 20%;
        white-space: pre-line;
        margin-top: 0px;
    }
    .textmota{
        white-space: pre-line;
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
    #xoa, #sua{
        padding: 5px;
        background-color: blue;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        margin-right: 5px;
    }
    #xoa:hover, #sua:hover{
        background-color: green;
    }
    textarea {
      resize: none; /* Ngăn chặn resize tự do của textarea */
    }
    label{
        font-size: 19px;
    }
</style>
<div id="capnhat" class="w3-modal" style="border-radius: 5px;">
    <div class="w3-modal-content w3-animate-zoom" style="width: 800px; border-radius: 5px;">
        <div class="w3-container" >
            <span onclick="closeModal()" class="w3-button w3-display-topright">&times;</span>
            <h2 style="color: blue; font-weight: bold; text-align: center; text-transform:uppercase">Cập nhật đề tài</h2>
            <form action="../../Xuly/Xuly_XML/Xuly_xoadetai.php" method="post" style="margin-bottom: 20px;">
                <input type="text" style="display: none;" readonly id="madetai_sua" name="madetai_sua">
                <input type="text" style="display: none;" readonly id="trangthai" name="trangthai">

                <label class="w3-text">Tên đề tài:</label>
                <textarea class="w3-input w3-border" id="tendetai" name="tendetai" rows="5" required></textarea>

                <label class="w3-text">Mô tả:</label>
                <textarea class="w3-input w3-border" id="mota_sua" name="mota_sua" rows="8" required></textarea>
                
                <br>
                <button type="submit" class="w3-button w3-blue" name="sbmcapnhat_detai">Cập nhật</button>
                <button type="button" onclick="closeModal()" class="w3-button w3-red nhapexcel">Hủy</button>
            </form>
        </div>
    </div>
</div>
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
                    <th class="table-header">Ngành học</th>
                    <th class="table-header">Năm học</th>                    
                    <th class="table-header">Trạng thái xét duyệt</th>
                    <th class="table-header">Ghi chú</th>
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
                $xmlFilePath_dk = '../../QuanlyXML/Dangky.xml';
                $xml_dk = simplexml_load_file($xmlFilePath_dk);
                $xmlFilePath_tg = '../../QuanlyXML/Thoigiantao_dangky.xml';
                $xml_tg = simplexml_load_file($xmlFilePath_tg);
                $i = 1;
                foreach ($xml->detai as $detai) {
                    
                    if((String)$detai->msgv == $_SESSION["user"]){
                        echo "<tr>";
                        $madetai = $detai["madetai"];
                        echo "<td id='stt'>".$i++."</td>";
                        echo "<td class='mota'>{$detai->tendetai}</td>";
                        $tendetai = $detai->tendetai;
                        
                        echo "<td class='mota'>{$detai->mota}</td>";
                        
                        $manganhParts = explode('-', $detai->maloaidoan);
                        $maloaidoan = $detai->maloaidoan;
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
                        foreach ($xml2->nganh as $nganh) {
                            if((String)$manganhAfterDash == (String)$nganh['manganh']){
                                echo "{$nganh->tennganh}";
                                break;
                            }
                        }
                        "</td>";
                        echo "<td>{$detai->namhoc}</td>";
                        echo "<td id='trangthai'>";
                        if($detai->trangthaixetduyet == 0){
                            echo "Chưa duyệt";
                        }elseif($detai->trangthaixetduyet == 1){
                            echo "Đạt";
                        }else{
                            echo "Không đạt";
                        }
                        $trangthai = $detai->trangthaixetduyet;
                        "</td>";
                        echo "<td>{$detai->ghichu}</td>"; 
                        $ktdk ="";
                        $mota = str_replace("\n", " ", $detai->mota);
                        $tg = "";
                        foreach($xml_tg->thoigian as $thoigian){
                            if($maloaidoan == (string)$thoigian->maloaidoan && $thoigian->quyen == "giangvien"){
                                if($thoigian->ngayketthuc >= date("Y-m-d")){
                                    $tg = "1";
                                    break;
                                }
                            }
                        }
                        if($tg == "1"){
                            echo "<td style='text-align: center;'>
                                    <a id='sua' href='#?mota=$mota' onclick='return openModal(\"$madetai\", \"$tendetai\", \"$mota\", \"$trangthai\")'>Sửa</a>";
                                    foreach($xml_dk->dangky as $dangky){
                                        if((string)$dangky->madetai == (string)$detai["madetai"]){
                                            $ktdk = "1";
                                            break;
                                        }
                                    }
                                    if($ktdk != "1"){
                                        echo "<a onclick=\"return confirm('Bạn có thật sự muốn xóa đề tài này hay không?')\" id='xoa' href='../../Xuly/Xuly_XML/Xuly_xoadetai.php?maxoa=$madetai'>Xóa</a>";
                                    }else{
                                        $ktdk = "";
                                    }
                                "</td>";
                        }
                        else{
                            echo "<td style='color: gray;'><p><i>Đã đóng</i></p></td>";
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
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
        $('#malop').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                return undefined;
            },
            maximumSelectionLength: 1,
        });
    });

    function openModal(madetai, tendetai, mota, trangthai) {
        document.getElementById('capnhat').style.display = 'block';
        document.getElementById('madetai_sua').value =madetai;
        document.getElementById('trangthai').value =trangthai;
        document.getElementById('tendetai').value = tendetai;
        document.getElementById('mota_sua').value = mota;
        
    }

    function closeModal() {
        uploadButtonClicked = false;
        document.getElementById('capnhat').style.display = 'none';
    }
    </script>
</div>
<?php
    include("footer-giangvien.php")
?>