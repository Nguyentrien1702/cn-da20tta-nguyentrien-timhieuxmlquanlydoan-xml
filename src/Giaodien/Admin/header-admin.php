<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <style>
    #footer{
      margin-top: 20%;
    }
  </style>
</head>
<body style="background-color: beige">
  <?php
  // Start the session
  session_start();
  ?>
  <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-blue w3-card" style="font-weight: 600;">
      <a href="#" class="w3-bar-item w3-button w3-padding-large"><img width="25px" src="../../images/logotvu.png" alt="logo-tvu">
      <a href="Giaodien_admin.php" class="w3-bar-item w3-button w3-padding-large">Trang chủ</a>
      <div class="w3-dropdown-hover w3-hide-small">
        <button class="w3-padding-large w3-button" title="More">Quản lý GV-SV <i class="fa fa-caret-down"></i></button>     
        <div class="w3-dropdown-content w3-bar-block w3-card-4">
          <a href="giangvien.php" class="w3-bar-item w3-button">Quản lý giảng viên</a>
          <a href="sinhvien.php" class="w3-bar-item w3-button">Quản lý sinh viên</a>
        </div>
      </div>
      <a href="detai.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Quản lý đề tài</a>
      <a href="dsdangky.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Quản lý đăng ký</a>
      <div class="w3-dropdown-hover w3-hide-small">
        <button class="w3-padding-large w3-button" title="More">Quản lý khác <i class="fa fa-caret-down"></i></button>  
        <div class="w3-dropdown-content w3-bar-block w3-card-4">
          <a href="nganh.php" class="w3-bar-item w3-button">Quản lý ngành</a>
          <a href="lop.php" class="w3-bar-item w3-button">Quản lý lớp</a>
          <a href="hocky.php" class="w3-bar-item w3-button">Quản lý học kỳ</a>
          <a href="loaidoan.php" class="w3-bar-item w3-button">Quản lý loại đồ án</a>
          <a href="loaidetai.php" class="w3-bar-item w3-button">Quản lý loại đề tài</a>
          <a href="Taikhoan.php" class="w3-bar-item w3-button">Quản lý tài khoản</a>
        </div>
      </div>
      
  <?php
    if($_SESSION["tennguoidung"] != null)
        echo ("<a href='../../index.php' class='w3-bar-item w3-button w3-padding-large w3-hide-small w3-right'>Chào: " . $_SESSION["tennguoidung"]." (Thoát)</a>");
  ?>
    </div>
  </div class="w3-top"> 
  <div class="w3-content" style="max-width:3000px; margin-top:46px">