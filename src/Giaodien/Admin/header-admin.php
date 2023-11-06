<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
// Start the session
session_start();
?>
<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-gray w3-card">
    <a href="#" class="w3-bar-item w3-button w3-padding-large">Trang chủ</a>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="More">Quản lý GV-SV <i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button">Quản lý giảng viên</a>
        <a href="#" class="w3-bar-item w3-button">Quản lý sinh viên</a>
      </div>
    </div>
    <a href="#" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Quản lý đề tài</a>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="More">Quản lý khác <i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button">Quản lý ngành</a>
        <a href="#" class="w3-bar-item w3-button">Quản lý lớp</a>
        <a href="#" class="w3-bar-item w3-button">Quản lý học kỳ</a>
        <a href="#" class="w3-bar-item w3-button">Quản lý loại đồ án</a>
        <a href="#" class="w3-bar-item w3-button">Quản lý đồ án</a>
      </div>
    </div>
    <a href="#" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Quản lý đăng ký</a>
<?php
if($_SESSION["tennguoidung"] != null)
    echo ("<a href='../../index.php' class='w3-bar-item w3-button w3-padding-large w3-hide-small w3-right'>Chào: " . $_SESSION["tennguoidung"]." (Thoát)</a>");
?>
  </div>
  </div class="w3-top"> 
  <div class="w3-content" style="max-width:2000px; margin-top:46px">