<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"/>

</head>
<body style="background-color: beige;">
<?php
// Kiểm tra xem có tham số URL "Tentaikhoan" được truyền
if (isset($_GET['tentaikhoan']) && isset($_GET['p'])) {
    $tenDangNhap = $_GET['tentaikhoan'];
    $loi = $_GET['p'];
} else {
    $tenDangNhap = "";
    $loi = "";
}
?>
<form name="formquenmatkhau" action="../Xuly/Xuly_Quenmatkhau.php" method="post" onsubmit="return ssmatkhau()">
      <div>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row border rounded-4 p-3 bg-white shadow box-area">
              <!-- left-->
              <div class="col-md-5 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="padding-right: 30px; padding-left: 25px;">
                <div class="fictured-image">
                  <img src="../images/logotvu.png" class="img-fluid" style="max-width: 250px"/>
                </div>
              </div>
              <!-- right-->
              <div class="col-md-7 right-box">
                <div class="row align-items-center">
                  <div class="header-text">
                    <h3 class="mb-4"  style="color: blue; text-align:center"><strong>Quên mật khẩu</strong></h3>
                    <!-- Tên đăng nhập-->
                    <div class="input-group mb-3"> 
                      <input type="text" id="txttentaikhoan" name="txttentaikhoan" class="form-control form-control-lg bg-light fs-6" placeholder="Tên đăng nhập" value="<?php echo $tenDangNhap; ?>" required/>
                    </div>
                    <!-- Họ tên-->
                    <div class="input-group mb-3"> 
                      <input type="text" id="txthoten" name="txthoten" class="form-control form-control-lg bg-light fs-6" placeholder="Họ và tên" required/>
                    </div>
                    <!-- Mật khẩu mới-->
                    <div class="input-group mb-3">
                      <input type="password" id="txtmatkhau" name="txtmatkhau" class="form-control form-control-lg bg-light fs-6" placeholder="Mật khẩu mới" required/>
                    </div>
                    <!--Xác nhận mật khẩu mới-->
                    <div class="input-group mb-3">
                      <input type="password" id="txtxnmatkhau" name="txtxnmatkhau" class="form-control form-control-lg bg-light fs-6" placeholder="Nhập lại mật khẩu" required/>
                    </div>
                    <!-- Thông báo-->
                    <div class="input-group mb-3">
                        <p id="alert" style="color: red; padding-left: 10px"><?php echo $loi; ?> </p>
                    </div>
                    <div style="display: flex;">
                      <div class="input-group mb-3">
                          <input type="submit" name="sbxacnhan" class="btn btn-lg btn-primary w-100 fs-6 p-1" value="Xác nhận">
                      </div>
                      &nbsp;
                      <div class="input-group mb-3">
                          <input type="button" name="sbhuy" onclick="window.location.href='../index.php'" class="btn btn-lg btn-primary w-100 fs-6 p-1" value="Hủy">
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- right-box-->
            </div><!-- row box-area-->
          </div><!-- container-->
      </div>
    </form>
  <script>
    // Lấy tham chiếu đến các trường input và thẻ p "alert"
    const txtTentaikhoan = document.getElementById("txttentaikhoan");
    const txthoten = document.getElementById("txthoten");
    const txtMatkhau = document.getElementById("txtmatkhau");
    const txtmkmoi = document.getElementById("txtxnmatkhau");
    const alertP = document.getElementById("alert");

    // Sử dụng sự kiện click để ẩn thẻ "alert" khi một trong hai trường input được click
    txtTentaikhoan.addEventListener("click", function () {
        alertP.style.display = "none";
    });
    txthoten.addEventListener("click", function () {
        alertP.style.display = "none";
    });

    txtMatkhau.addEventListener("click", function () {
        alertP.style.display = "none";
    });
    txtmkmoi.addEventListener("click", function () {
        alertP.style.display = "none";
    });
    
    function ssmatkhau(){
      if(txtMatkhau.value !== txtmkmoi.value){
        alertP.textContent= "xác nhận mật khẩu chưa đúng";
        alertP.style.display = "block";
        txtmkmoi.nodeValue="";
        return false;
      }
      else return true;
    }
</script>
</body>
</html>