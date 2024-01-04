<?php
  include("header-admin.php")
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

.mota {
    width: 20%;
    white-space: pre-line;
    margin-top: 0px;
}

.tick-symbol,
.cross-symbol {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.tick-symbol,
.cross-symbol {
    text-decoration: none;
    padding: 7px;
    font-size: 20px;
    font-weight: bolder;
    border-radius: 5px;
}

.tick-symbol {
    background-color: cadetblue;
}

.cross-symbol {
    background-color: cadetblue;
}

/* Dấu tick khi nút được hover */
.tick-symbol:hover {
    font-size: 25px;
    color: green;
    /* Màu sắc khi hover */
}

/* Dấu x khi nút được hover */
.cross-symbol:hover {
    font-size: 25px;
    color: red;
    /* Màu sắc khi hover */
}

th {
    text-align: center;
}

td,
th {

    vertical-align: middle !important;
}

h1#td {
    text-transform: uppercase;
    font-weight: bolder;
    color: blue;
}
textarea {
      resize: none; /* Ngăn chặn resize tự do của textarea */
}
</style>
<?php
$xmlFilePath1 = '../../QuanlyXML/Nganh.xml';
$xml1 = simplexml_load_file($xmlFilePath1);
  // Đường dẫn đến file XML
  $xmlFile = "../../QuanlyXML/Hocky.xml";

  // Đọc nội dung từ file XML
  $xmlContent = file_get_contents($xmlFile);

  // Chuyển đổi XML thành đối tượng SimpleXML
  $xml = simplexml_load_string($xmlContent);

  // Mảng để lưu trữ các khóa duy nhất
  $uniqueKeys = [];

  // Lặp qua các lớp trong XML
  foreach ($xml->hocky as $hocky) {
      // Lấy giá trị của thuộc tính 'năm học'
      $namhoc = (string)$hocky->nienkhoa;

      // Kiểm tra xem khóa đã được thêm vào mảng chưa
      if (!in_array($namhoc, $uniqueKeys)) {
          // Nếu chưa thêm, thêm vào mảng
          $uniqueKeys[] = $namhoc;
      }
  }

  // Sắp xếp mảng theo giá trị tăng dần
  sort($uniqueKeys);

?>

<div>
    <button id="themmoi" class="w3-button w3-green" onclick="openModal()" style="margin: 20px 40px;">Tạo thời
        gian</button>
    <div id="uploadModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom" style="width: 400px;">
            <div class="w3-container" style="height: 550px;">
                <span onclick="closeModal()" class="w3-button w3-display-topright">&times;</span>
                <h2 style="color: blue; font-weight: bold;">Tạo thời gian đồ án</h2>
                <form action="../../Xuly/Xuly_taothoigian.php" method="post">

                    <label for="quyen">Quyền:</label>
                    <select class="w3-input w3-border" id='quyen' name='txtquyen' required>
                        <option value="giangvien">Giảng viên</option>
                        <option value="sinhvien">Sinh viên</option>
                    </select>

                    <label for="loaidoan">Loại đồ án:</label>
                    <select class="w3-input w3-border" id='loaidoan' name='txtloaidoan' required>
                        <option value="CSN">Đồ án cơ sở ngành</option>
                        <option value="CN">Đồ án chuyên ngành</option>
                        <option value="TT">Thực tập</option>
                    </select>

                    <label for="manganh_sua">Chọn Ngành:</label>
                    <select class="w3-input w3-border" id='manganh_sua' name='txtmanganh' class="form-select" required>
                        <?php
                        foreach ($xml1->nganh as $nganh){
                            if((string)$nganh['manganh'] == $_GET["manganh"]){
                                echo "<option selected value = " . $nganh['manganh'] . ">";
                                echo $nganh['manganh'] . " - " . $nganh->tennganh;
                                echo "</option>";
                            }
                            else{
                                echo "<option value = " . $nganh['manganh'] . ">";
                                echo $nganh->tennganh;
                                echo "</option>";
                            }
                        }
                    ?>
                    </select>

                    <label for="khoaSelect">Năm học:</label>
                    <select class="w3-input w3-border" id="khoa" name="txtkhoa">
                    <?php
                    // Lặp qua mảng khóa và tạo các option
                    foreach ($uniqueKeys as $khoa) {
                        echo "<option value=\"$khoa\">$khoa</option>";
                    }
                    ?>
                    </select>

                    <label class="w3-text">Ngày bắt đầu:</label>
                    <input class="w3-input w3-border w3-datepicker" min="<?php echo date('Y-m-d'); ?>" type="date"
                        id="ngaybd" name="ngaybd" placeholder="Chọn ngày" required>

                    <label class="w3-text">Ngày kết thúc:</label>
                    <input class="w3-input w3-border w3-datepicker" type="date" id="ngaykt" name="ngaykt"
                        placeholder="Chọn ngày" required>
                    <br>
                    <button type="submit" class="w3-button w3-blue" name="sbmthem_thoigian">Thêm</button>
                    <button type="button" onclick="closeModal()" class="w3-button w3-red nhapexcel">Hủy</button>
                </form>
            </div>
        </div>
    </div>

    <div id="capnhat" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom" style="width: 400px;">
            <div class="w3-container" style="height: 300px;">
                <span onclick="closeModalUpdate()" class="w3-button w3-display-topright">&times;</span>
                <h2 style="color: blue; font-weight: bold;">Cập nhật thời gian</h2>
                <form action="../../Xuly/Xuly_taothoigian.php" method="post">
                    <input type="text" style="display: none;" id="matg_sua" name="matg_sua">
                    <label class="w3-text">Ngày bắt đầu:</label>
                    <input class="w3-input w3-border w3-datepicker" 
                         type="date" id="ngaybd_sua" name="ngaybd_sua" placeholder="Chọn ngày"
                        required>

                    <label class="w3-text">Ngày kết thúc:</label>
                    <input class="w3-input w3-border w3-datepicker" type="date" id="ngaykt_sua" name="ngaykt_sua"
                         placeholder="Chọn ngày" required>
                    <br>
                    <button type="submit" class="w3-button w3-blue" name="sbmcapnhat_thoigian">Cập nhật</button>
                    <button type="button" onclick="closeModalUpdate()" class="w3-button w3-red nhapexcel">Hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="div-content">
    <h1 id="td">Các hoạt động</h1>
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
                <th class="table-header">Thao tác</th>
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
                    $matg = $thoigian['matg'];
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
                      $ngaybd = date('d-m-Y', strtotime($thoigian->ngaybatdau));
                      $ngaykt = date('d-m-Y', strtotime($thoigian->ngayketthuc));
                    if(($thoigian->ngaybatdau<= date("Y-m-d")) && ($thoigian->ngayketthuc >= date("Y-m-d"))){
                        echo "<td style='color: green'>Đang diễn ra</td>";
                    }elseif(($thoigian->ngaybatdau > date("Y-m-d"))){
                        echo "<td style='color: blue'>Sắp diễn ra</td>";
                    }else{
                        echo "<td style='color: red'>Đã đóng</td>";
                    }
                    
                    echo "<td style='text-align: center;'>";
                        echo "<a id='sua' href='#' onclick='openUpdateModal(\"$matg\",\"$ngaybd\", \"$ngaykt\")' style='margin-right: 5px'>sửa</a>";
                        // echo "<button id='sua' type='button' onclick='openUpdateModal()' style='margin-right: 5px'>sửa</button>";
                        
                            echo "<a onclick=\"return confirm('Bạn có thật sự muốn xóa đề tài này hay không?')\" id='xoa' href='../../Xuly/Xuly_taothoigian.php?matg_xoa=$matg'>Xóa</a>";
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
        </tbody>
    </table>
</div>


<?php
    function trangthai(){
        $xmlFilePath = '../../QuanlyXML/Detai.xml';
        $xml = simplexml_load_file($xmlFilePath);
        foreach ($xml->detai as $detai) {
            if($detai->trangthaixetduyet == 0){
                return 1;
            }
        }
    }
    if(trangthai() == 1){
       echo "<hr style='border: 2px solid black; margin: 40px'>";
?>
    <div id="ghichu" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom" style="width: 400px;">
            <div class="w3-container" style="height: 300px;">
                <span onclick="closeModalghichu()" class="w3-button w3-display-topright">&times;</span>
                <form action="../../Xuly/Xuly_XML/Xuly_duyetdetai.php" method="post" style="margin-top: 30px;">
                    <input type="text" style="display:none;" id="madetai" name="madetai">
                    <label class="w3-text">Lí do:</label>
                    <textarea id="lidobo" name="lido" class="w3-input w3-border w3-datepicker"></textarea>

                    <br>
                    <button type="submit" class="w3-button w3-blue" name="sbmghichu">Xác nhận</button>
                    <button type="button" onclick="closeModalghichu()" class="w3-button w3-red nhapexcel">Hủy</button>
                </form>
            </div>
        </div>
    </div>
<div class="div-content">
    <h1 style="text-transform: uppercase; font-weight: bolder; Color: blue; text-align:center">Danh sách đề tài chờ xét duyệt</h1>
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
                <th class="table-header">Thao tác</th>
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
                        if($detai->trangthaixetduyet == 0){
                        echo "<tr>";
                        $madetai = $detai['madetai'];
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
                        echo "<td style='text-align: center;'>
                            <a id='duyet' href='../../Xuly/Xuly_XML/Xuly_duyetdetai.php?duyet_madetai={$detai['madetai']}' class='tick-symbol'>&#10003;</a>
                            <a onclick='return openModalghichu(\"$madetai\")' id='loaibo' class='cross-symbol' href=''>&#10007;</a>
                          </td>";
                        echo "</tr>";}
                    }
            ?>
        </tbody>
    </table>
</div>
<?php
    }
?>

<script>
function openModal() {
    uploadButtonClicked = true;
    document.getElementById('uploadModal').style.display = 'block';
}

function closeModal() {
    uploadButtonClicked = false;
    document.getElementById('uploadModal').style.display = 'none';
}
function openModalghichu(madetai) {
    document.getElementById('madetai').value = madetai;
    document.getElementById('lidobo').innerHTML = "";
    document.getElementById('ghichu').style.display = 'block';
    return false; // Ngăn chặn sự kiện mặc định (chẳng hạn khi nút là một liên kết)
}

function closeModalghichu() {
    uploadButtonClicked = false;
    document.getElementById('lidobo').innerHTML = "";
    document.getElementById('ghichu').style.display = 'none';
}

document.getElementById('ngaybd').addEventListener('change', function() {
    var ngaybdValue = this.value;
    document.getElementById('ngaykt').min = ngaybdValue;
});

function openUpdateModal(matg, ngaybd, ngaykt) {
    // Chuyển đổi định dạng ngày từ 'd-m-Y' sang 'Y-m-d'
    var ngaybdFormatted = ngaybd.split('-').reverse().join('-');
    var ngayktFormatted = ngaykt.split('-').reverse().join('-');
    document.getElementById('ngaybd_sua').min = ngaybdFormatted;
    document.getElementById('ngaykt_sua').min = ngaybdFormatted;
    // Gán giá trị cho thẻ input
    document.getElementById('matg_sua').value = matg;
    document.getElementById('ngaybd_sua').value = ngaybdFormatted;
    document.getElementById('ngaykt_sua').value = ngayktFormatted;
    // Mã để mở modal
    document.getElementById('capnhat').style.display = 'block';
}
function closeModalUpdate() {
    uploadButtonClicked = false;
    document.getElementById('capnhat').style.display = 'none';
}
</script>
<?php
  include("footer-admin.php")
?>