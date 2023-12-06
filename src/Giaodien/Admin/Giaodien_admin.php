<?php
  include("header-admin.php")
?>
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
    <button id="themmoi" class="w3-button w3-green" onclick="openModal()" style="margin: 20px 20px;">Tạo thời
        gian</button>
    <div id="uploadModal" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom" style="width: 400px;">
            <div class="w3-container" style="height: 550px;">
                <span onclick="closeModal()" class="w3-button w3-display-topright">&times;</span>
                <h2>Tạo thời gian đồ án</h2>
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
                    <input class="w3-input w3-border w3-datepicker" min="<?php echo date('Y-m-d'); ?>" type="date" id="ngaybd" name="ngaybd"
                        placeholder="Chọn ngày"  required>

                    <label class="w3-text">Ngày kết thúc:</label>
                    <input class="w3-input w3-border w3-datepicker" type="date" id="ngaykt" name="ngaykt"
                        placeholder="Chọn ngày" required>
                    <br>
                    <button type="submit" class="w3-button w3-green" name="sbmthem_thoigian">Thêm</button>
                    <button type="button" onclick="closeModal()" class="w3-button w3-red nhapexcel">Hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="custom-datatable-style">
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Công việc</th>
                <th class="table-header" >Người thực hiện</th>
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
                            <a id='sua' href='#'>Sửa</a>
                            <a onclick=\"return confirm('Bạn có thật sự muốn xóa đề tài này hay không?')\" id='xoa' href='#'>Xóa</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
        </tbody>
    </table>
</div>

<script>
function openModal() {
    uploadButtonClicked = true;
    document.getElementById('uploadModal').style.display = 'block';
}

function closeModal() {
    uploadButtonClicked = false;
    document.getElementById('uploadModal').style.display = 'none';
}

document.getElementById('ngaybd').addEventListener('change', function() {
    var ngaybdValue = this.value;
    document.getElementById('ngaykt').min = ngaybdValue;
});

</script>
<?php
  include("footer-admin.php")
?>