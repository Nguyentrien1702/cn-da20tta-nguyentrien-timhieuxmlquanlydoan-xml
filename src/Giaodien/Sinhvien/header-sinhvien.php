<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
    body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="w3-light-grey w3-content" style="max-width:100%">
<!-- Navigation bar with social media icons -->
<div class="w3-bar w3-gray w3-hide-small">
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-facebook-official"></i></a>    
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container">
    <img src="#" style="width:45%;" class="w3-round"><br><br>
    <h5><b>Tên người dùng</b></h5>
    
  </div>
  <div class="w3-bar-block">
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user w3-margin-right"></i>Thông tin cá nhân</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-arrow-right w3-margin-right"></i>Đăng ký đồ án</a>
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-lock w3-margin-right"></i>Đổi mật khẩu</a> 
    <?php
    session_start();
    if($_SESSION["tennguoidung"] != null)
      echo ("<a href='../../index.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-remove w3-margin-right'></i>Chào: " . $_SESSION["tennguoidung"]." (Thoát)</a>");
    ?>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">
    <!-- Header -->
  <header id="portfolio">
    <a href="javascript:void(0)" class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></a>
  </header>
  
  <div>
