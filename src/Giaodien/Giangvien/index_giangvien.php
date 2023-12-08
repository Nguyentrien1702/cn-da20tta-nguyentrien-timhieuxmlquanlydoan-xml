<?php
  include("header-giangvien.php")
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
}
td, th{
    text-align: center;
    vertical-align: middle !important;
}
</style>
  <div class="div-content">
    <h1>Các hoạt động</h1>
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Công việc</th>
                <th class="table-header">Người thực hiện</th>
                <th class="table-header">Loại đồ án</th>
                <th class="table-header">Ngành</th>
                <th class="table-header">Năm học</th>
                <th class="table-header">Ngày bắt đầu</th>
                <th class="table-header">Ngày kết thúc</th>
                <th class="table-header">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $xmlFilePath = '../../QuanlyXML/Thoigiantao_dangky.xml';
                $xml = simplexml_load_file($xmlFilePath);
                $xmlFilePath1 = '../../QuanlyXML/Loaidoan.xml';
                $xml1 = simplexml_load_file($xmlFilePath1);
                $xmlFilePath2 = '../../QuanlyXML/Nganh.xml';
                $xml2 = simplexml_load_file($xmlFilePath2);
                $i = 1;
                foreach ($xml->thoigian as $thoigian) {
                    echo "<tr>";
                    echo "<td id='stt'>".$i++."</td>";
                    if($thoigian->quyen == "giangvien"){
                      echo "<td>Ra đề tài</td>";
                      echo "<td>Giảng viên</td>";
                      $gv_sv = 0;
                    }else{
                      echo "<td>Đăng ký đề tài</td>";
                      echo "<td>Sinh viên</td>";
                      $gv_sv = 1;
                    }
                    foreach ($xml1->loaidoan as $loaidoan) {
                      if((string)$loaidoan['maloaidoan'] == (string)$thoigian->maloaidoan){
                        echo "<td>".$loaidoan->tenloai."</td>";
                        break;
                      }
                    }
                    $ma =explode("-", $thoigian->maloaidoan);
                    $manganh = end($ma);
                    foreach ($xml2->nganh as $nganh) {
                        if((string)$nganh['manganh'] == $manganh){
                          echo "<td>".$nganh->tennganh."</td>";
                          break;
                        }
                      }
                    echo "<td>".$thoigian->namhoc."</td>";
                    echo "<td>".date('d-m-Y', strtotime($thoigian->ngaybatdau))."</td>";
                    echo "<td>".date('d-m-Y', strtotime($thoigian->ngayketthuc))."</td>";

                    if(($thoigian->ngaybatdau<= date("Y-m-d")) && ($thoigian->ngayketthuc >= date("Y-m-d"))){
                        echo "<td style='color: green'>Đang diễn ra</td>";
                    }elseif(($thoigian->ngaybatdau > date("Y-m-d"))){
                        echo "<td style='color: blue'>Sắp diễn ra</td>";
                    }else{
                        echo "<td style='color: red'>Đã đóng</td>";
                    }

                    echo "<td style='text-align: center;'>
                            </td>";
                    echo "</tr>";
                }
                ?>
        </tbody>
    </table>
</div>
<?php
  include("footer-giangvien.php")
?>