<?php
  include("header-giangvien.php")
?>
  <style>
  label{
    margin-top: 15px;
  }
</style>
<div>
    <h2 style="font-weight: bold; color: red; margin-bottom: 30px; text-align: center; ">THÔNG TIN CÁ NHÂN</h2>

    <?php
      $file_path = '../../QuanlyXML/Giangvien.xml';
      $msgv_to_find = $_SESSION["user"];

      // Load XML file
      $xml = simplexml_load_file($file_path);

      // Duyệt qua từng giảng viên trong file XML
      foreach ($xml->giangvien as $giangvien) {
          // Lấy giá trị của thuộc tính msgv
          $msgv = (string) $giangvien['msgv'];

          // So sánh msgv
          if ($msgv == $msgv_to_find) {
              // Lấy thông tin giảng viên
              $tengiangvien = (string) $giangvien->tengiangvien;
              $gioitinh = (string) $giangvien->gioitinh;
              $sodienthoai = (string) $giangvien->sodienthoai;
              $email = (string) $giangvien->email;
              $phong = (string) $giangvien->phong;
              
              // Thoát khỏi vòng lặp vì chúng ta đã tìm thấy giảng viên cần
              break;
          }
      }
    ?>
    <div id="formgiangvien" style="width: 50%; margin: auto">
        <form class="w3-container" action="#" method="post">
            <label for="msgv">Mã Số Giảng Viên:</label>
            <input class="w3-input w3-border" type="text" id="msgv" name="txtmsgv" value="<?php echo $msgv; ?>"
                readonly>

            <label for="tengiangvien">Tên Giảng viên Viên:</label>
            <input class="w3-input w3-border" type="text" id="tengiangvien" name="txttengiangvien"
                value="<?php echo $tengiangvien; ?>" required>

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

            <label for="phong_sua">Phòng:</label>
            <input class="w3-input w3-border" type="text" id="phong" name="txtphong" value="<?php echo $phong;?>">

            <button class='w3-btn w3-green' type='submit' name='sbmcapnhat' style="margin-top: 20px;">Cập nhật thông tin</button>

        </form>
    </div>
</div>

<?php

  if(isset($_POST["sbmcapnhat"])){
    $msgv = $_POST["txtmsgv"];
    $tengiangvien = $_POST["txttengiangvien"];
    $gioitinh = $_POST["rdgioitinh"];
    $sodienthoai = $_POST["txtsodienthoai"];
    $email = $_POST["txtemail"];
    $phong = $_POST["txtphong"];

    updategiangvien($file_path, $msgv, $tengiangvien, $gioitinh, $sodienthoai, $email, $phong);
    
  }

  function updategiangvien($file_path, $msgv, $tengiangvien, $gioitinh, $sodienthoai, $email, $phong) {
    $xml = simplexml_load_file($file_path);
    // Tìm và cập nhật thông tin Giảng viên
    foreach ($xml->giangvien as $giangvien) {
        if ((string)$giangvien['msgv'] === $msgv) {
            // Cập nhật Giảng viên
            $giangvien->tengiangvien = $tengiangvien;
            $giangvien->gioitinh = $gioitinh;
            $giangvien->sodienthoai = $sodienthoai;
            $giangvien->email = $email;
            $giangvien->phong = $phong;

            // Lưu thay đổi vào tệp XML
            $xml->asXML($file_path);
            echo '<script type="text/javascript">';
            echo 'alert("Cập nhật thành công thành công");';
            echo 'window.location.href  = "thongtincanhan.php";';
            echo '</script>';

            // Kết thúc vòng lặp vì đã tìm thấy và cập nhật Giảng viên
            break;
        }
    }
}
?>


<?php
  include("footer-giangvien.php")
?>
