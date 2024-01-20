<?php
  include("header-sinhvien.php");
  $user = $_SESSION["user"];
?>
<style>
.div-content {
    width: 95%;
    margin: auto;
}

h1 {
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 40px;
    text-align: center;
    color: blue;
}

td,
th {
    text-align: center;
    vertical-align: middle !important;
}

textarea {
    resize: none;
    /* Ngăn chặn resize tự do của textarea */
}

#btnluudetai {
    margin: 10px 10px;
    padding: 5px;
    background-color: #1a1aff;
    color: white;
    font-size: 16px;
    width: 80px;
    height: 40px;
    border-radius: 7px;
}

#btnluudetai:hover {
    background-color: #0000e6;
}
.mota {
    width: 25%;
    white-space: pre-line;
    margin-top: 0px;
    }
#huydangky{
    padding: 5px;
    background-color: blue;
    border-radius: 5px;
    color: white;
    text-decoration: none;
}
#huydangky:hover{
    background-color: green;
}
</style>

<div class="div-content">
    <h1>Các hoạt động</h1>
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header" >STT</th>
                <th class="table-header" >Công việc</th>
                <th class="table-header" >Người thực hiện</th>
                <th class="table-header" >Loại đồ án</th>
                <th class="table-header" >Ngành</th>
                <th class="table-header" >Năm học</th>
                <th class="table-header" >Ngày bắt đầu</th>
                <th class="table-header" >Ngày kết thúc</th>
                <th class="table-header" >Trạng thái</th>
                <!-- <th class="table-header" >Thao tác</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                $xmlFilePath = '../../QuanlyXML/Thoigiantao_dangky.xml';
                $xml = simplexml_load_file($xmlFilePath);
                $xmlFilePath1 = '../../QuanlyXML/Loaidoan.xml';
                $xml1 = simplexml_load_file($xmlFilePath1);
                $xmlFilePath_n = '../../QuanlyXML/Nganh.xml';
                $xml_n = simplexml_load_file($xmlFilePath_n);
                $i = 1;
                foreach ($xml->thoigian as $thoigian) {
                  if(($thoigian->ngayketthuc >= date("Y-m-d"))){
                    echo "<tr>";
                    echo "<td id='stt'>".$i++."</td>";
                    $matg = $thoigian["matg"];
                    if($thoigian->quyen == "giangvien"){
                      echo "<td>Ra đề tài</td>";
                      echo "<td>Giảng viên</td>";
                      $gv_sv = 0;
                    }else{
                      echo "<td>Đăng ký đề tài</td>";
                      echo "<td>Sinh viên</td>";
                      $gv_sv = 1;
                    }
                    $maloai = $thoigian->maloaidoan;
                    foreach ($xml1->loaidoan as $loaidoan) {
                      if((string)$loaidoan['maloaidoan'] == (string)$thoigian->maloaidoan){
                        echo "<td>".$loaidoan->tenloai."</td>";
                        break;
                      }
                    }
                    $ma =explode("-", $thoigian->maloaidoan);
                    $manganh = end($ma);
                    foreach ($xml_n->nganh as $nganh) {
                        if((string)$nganh['manganh'] == $manganh){
                          echo "<td>".$nganh->tennganh."</td>";
                          break;
                        }
                      }
                    echo "<td>".$thoigian->namhoc."</td>";
                    $namhoc = $thoigian->namhoc;
                    echo "<td>".date('d-m-Y', strtotime($thoigian->ngaybatdau))."</td>";
                    echo "<td>".date('d-m-Y', strtotime($thoigian->ngayketthuc))."</td>";

                    if(($thoigian->ngaybatdau<= date("Y-m-d")) && ($thoigian->ngayketthuc >= date("Y-m-d"))){
                        echo "<td style='color: green'>Đang diễn ra</td>";
                    }elseif(($thoigian->ngaybatdau > date("Y-m-d"))){
                        echo "<td style='color: blue'>Sắp diễn ra</td>";
                    }else{
                        echo "<td style='color: red'>Đã đóng</td>";
                    }
                    echo "<td></td>";
                    // if($gv_sv == 0){
                    //     echo "<td></td>";
                      
                    // }else{
                    //     echo "<td style='text-align: center;'>
                    //     <a  href='#?matg=$matg' style='margin-right: 5px; color: gray'>Danh sách sv đăng ký</a>
                    //         </td>";
                    // }
                    echo "</tr>";
                  }
                }
                ?>
        </tbody>
    </table>
</div>
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

    $manganh = "";
    $namhoc = "";
    $dadangky = "0";
    $mssv = $_SESSION["user"];
    foreach($xml_sv->sinhvien as $sinhvien){
        if($_SESSION["user"] == (string)$sinhvien["mssv"]){
            foreach($xml_l->lop as $lop){
                if((string)$lop["malop"] == (string)$sinhvien->malop){
                    $manganh = $lop->manganh;
                    break;
                }
            }
            break;
        }
    }
    foreach($xml_tg->thoigian as $thoigian){
        if(($thoigian->ngaybatdau<= date("Y-m-d")) && ($thoigian->ngayketthuc >= date("Y-m-d"))){
            if((string)$thoigian->quyen == "sinhvien"){                            
                $ma =explode("-", $thoigian->maloaidoan);
                $manganh_tg = end($ma);                            
                if($manganh == $manganh_tg){                                
                    $namhoc = $thoigian->namhoc;
                    break;
                }
            }
            
        }
        
    }
    foreach($xml_dk->dangky as $dangky){                            
        if((string)$dangky->mssv == $mssv && (string)$dangky->namhoc == $namhoc){
                $dadangky = "1";
        }
    }
    if($dadangky == "1"){
        ?>
        <div class="div-content">
        <hr style='border: 2px solid black; margin: 40px'>
        <h1>Đề tài đã đăng ký</h1>
        <?php
        $madetai="";
        $maloaidoan = "";
        $tendetai = "";
        $mota = "";
        $msgv_hd = "";
        $tengiangvien = "";
        $tensinhvien = "";
        $malop = "";
            foreach($xml_dk->dangky as $dangky){                            
                if((string)$dangky->mssv == $mssv && (string)$dangky->namhoc == $namhoc){
                        $madetai = $dangky->madetai; 
                        $msgv_hd = $dangky->msgv_hd;                                                        
                        break;
                }
            }
            foreach($xml_dt->detai as $detai){
                if((string)$detai['madetai'] == $madetai){
                    $tendetai = $detai->tendetai;
                    $mota = $detai->mota;
                    $maloaidoan = $detai->maloaidoan;
                    break;
                }
            }
            foreach($xml_gv->giangvien as $giangvien){
                if((string)$giangvien['msgv'] == $msgv_hd){
                    $tengiangvien = $giangvien->tengiangvien;
                    $sodienthoai = $giangvien->sodienthoai;
                    $phong = $giangvien->phong;
                }
            }
            foreach($xml_sv->sinhvien as $sinhvien){
                if((string)$sinhvien['mssv'] == $mssv){
                    $tensinhvien = $sinhvien->tensinhvien;
                    $malop = $sinhvien->malop;
                }
            }
            foreach($xml_lda->loaidoan as $loaidoan){
                if((string)$loaidoan['maloaidoan'] == $maloaidoan){
                    echo "<p><b>Loại đồ án: </b>".$loaidoan->tenloai."</p>";
                    break;
                }
            }
            foreach($xml_n->nganh as $nganh){
                if((string)$nganh['manganh'] == $manganh){
                    echo "<p><b>Ngành: </b>".$nganh->tennganh."</p>";
                    echo "<p><b>Năm học: </b>".$namhoc."</p>";
                    break;
                }
            }
        ?>
        <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
            <thead>
                <tr>
                    <th class="table-header" >Tên đề tài</th>
                    <th class="table-header" >Mô tả</th>
                    <th class="table-header" >GV hướng dẫn</th>
                    <th class="table-header" >Số điện thoại</th>
                    <th class="table-header" >Phòng</th>
                    <th class="table-header" style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //echo '<script type="text/javascript">alert("'.$madetai.'");</script>';
                    echo "<td class='mota'>".$tendetai."</td>";
                    echo "<td class='mota'>".$mota."</td>";
                    echo "<td>".$tengiangvien."</td>";
                    echo "<td>".$sodienthoai."</td>";
                    echo "<td>".$phong."</td>";
                    foreach($xml_tg->thoigian as $thoigian){
                        if(($thoigian->ngaybatdau<= date("Y-m-d")) && ($thoigian->ngayketthuc >= date("Y-m-d"))){
                            if((string)$thoigian->quyen == "sinhvien"){
                                echo "<td  style='text-align: center;'>
                                <a id='huydangky' href='../../Xuly/Xuly_XML/Xuly_huydangky.php?madetai_huy=$madetai'>Hủy đăng ký</a>
                                </td>";
                                break;
                            }
                        }//else{
                        //     echo "<p><i>Ngoài thời gian</i></p>";
                        // }
                    }
                ?>
            </tbody>
        </table>
        </div>
    <?php
        }

    ?>


<script>

</script>
<?php
  include("footer-sinhvien.php")
?>