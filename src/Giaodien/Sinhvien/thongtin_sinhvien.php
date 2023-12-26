<?php
  include("header-sinhvien.php")
?>
<style>
  label{
    margin-top: 15px;
  }
</style>
<div>
    <h2 style="font-weight: bold; color: blue; margin-bottom: 30px; text-align: center; ">THÔNG TIN CÁ NHÂN</h2>

    <?php
      $file_path = '../../QuanlyXML/Sinhvien.xml';
      $file_path1 = '../../QuanlyXML/Lop.xml';
      $mssv_to_find = $_SESSION["user"];

      // Load XML file
      $xml = simplexml_load_file($file_path);
      $xml1 = simplexml_load_file($file_path1);

      // Duyệt qua từng sinh viên trong file XML
      foreach ($xml->sinhvien as $sinh_vien) {
          // Lấy giá trị của thuộc tính mssv
          $mssv = (string) $sinh_vien['mssv'];

          // So sánh MSSV
          if ($mssv == $mssv_to_find) {
              // Lấy thông tin sinh viên
              $tensinhvien = (string) $sinh_vien->tensinhvien;
              $gioitinh = (string) $sinh_vien->gioitinh;
              $sodienthoai = (string) $sinh_vien->sodienthoai;
              $email = (string) $sinh_vien->email;
              $malop = (string) $sinh_vien->malop;
              foreach ($xml1->lop as $lop) {
                if ((string) $lop['malop'] == $malop) {
                  $tenlop = (string) $lop->tenlop;
                  $khoa = (string) $lop->khoa;
                }break;
              }
              // Thoát khỏi vòng lặp vì chúng ta đã tìm thấy sinh viên cần
              break;
          }
      }
    ?>
    <div id="formsinhvien" style="width: 50%; margin: auto">
        <form class="w3-container" action="#" method="post">
            <label for="mssv">Mã Số Sinh Viên:</label>
            <input class="w3-input w3-border" type="text" id="mssv" name="txtmssv" value="<?php echo $mssv; ?>"
                readonly>

            <label for="tensinhvien">Tên Sinh Viên:</label>
            <input class="w3-input w3-border" type="text" id="tensinhvien" name="txttensinhvien"
                value="<?php echo $tensinhvien; ?>" required>

            <label>Giới Tính:</label>
            <label><input class="w3-radio w3-margin-left" type="radio" name="rdgioitinh" value="Nam" checked>
                Nam</label>
            <label><input class="w3-radio w3-margin-left" type="radio" name="rdgioitinh" value="Nữ"
                    <?php  if ($gioitinh == "Nữ") echo 'checked'; ?>> Nữ</label>
            <br>
            <label for="sodienthoai">Số Điện Thoại:</label>
            <input class="w3-input w3-border" type="text" id="sodienthoai" name="txtsodienthoai"
                value="<?php echo $sodienthoai; ?>">

            <label for="email">Email:</label>
            <input class="w3-input w3-border" type="text" id="email" name="txtemail" value="<?php echo $email; ?>">

            <label for="malop_sua">Mã Lớp:</label>
            <input class="w3-input w3-border" type="text" id="lop" name="txtlop" value="<?php echo $malop." - ". $tenlop. " khóa ". $khoa; ?>">

            <button class='w3-btn w3-blue' type='submit' name='sbmcapnhat' style="margin-top: 20px; border-radius: 5px;">Cập nhật thông tin</button>

        </form>
    </div>
</div>

<?php

  if(isset($_POST["sbmcapnhat"])){
    $mssv = $_POST["txtmssv"];
    $tensinhvien = $_POST["txttensinhvien"];
    $gioitinh = $_POST["rdgioitinh"];
    $sodienthoai = $_POST["txtsodienthoai"];
    $email = $_POST["txtemail"];

    updatesinhvien($file_path, $mssv, $tensinhvien, $gioitinh, $sodienthoai, $email);
    
  }

  function updatesinhvien($file_path, $mssv, $tensinhvien, $gioitinh, $sodienthoai, $email) {
    $xml = simplexml_load_file($file_path);
    // Tìm và cập nhật thông tin Giảng viên
    foreach ($xml->sinhvien as $sinhvien) {
        if ((string)$sinhvien['mssv'] === $mssv) {
            // Cập nhật Giảng viên
            $sinhvien->tensinhvien = $tensinhvien;
            $sinhvien->gioitinh = $gioitinh;
            $sinhvien->sodienthoai = $sodienthoai;
            $sinhvien->email = $email;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($file_path);
            echo '<script type="text/javascript">';
            echo 'alert("Cập nhật thành công thành công");';
            echo 'window.location.href  = "index_sinhvien.php";';
            echo '</script>';

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Giảng viên
            break;
        }
    }
}
?>

<?php
  include("footer-sinhvien.php")
?>