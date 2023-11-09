<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"/>

</head>
<body>
<form name="formquenmatkhau" action="" method="post">
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
                    <h3 class="mb-4"><strong>Quên mật khẩu</strong></h3>
                    <!-- Tên đăng nhập-->
                    <div class="input-group mb-3"> 
                      <input type="text" ID="txttendangnhap" class="form-control form-control-lg bg-light fs-6" placeholder="Tên đăng nhập"/>
                    </div>
                    <!-- Họ tên-->
                    <div class="input-group mb-3"> 
                      <input type="text" ID="txthocten" class="form-control form-control-lg bg-light fs-6" placeholder="Họ và tên"/>
                    </div>
                    <!-- Mật khẩu mới-->
                    <div class="input-group mb-3">
                      <input type="password" ID="txtmatkhau" class="form-control form-control-lg bg-light fs-6" placeholder="Mật khẩu mới"/>
                    </div>
                    <!--Xác nhận mật khẩu mới-->
                    <div class="input-group mb-3">
                      <input type="password" ID="txtxnmatkhau" class="form-control form-control-lg bg-light fs-6" placeholder="Nhập lại mật khẩu"/>
                    </div>

                    <div class="input-group mb-3">
                        <input type="submit" ID="sbxacnhan" class="btn btn-lg btn-primary w-100 fs-6 p-1" value="Xác nhận">
                    </div>
                  </div>
                </div>
              </div><!-- right-box-->
            </div><!-- row box-area-->
          </div><!-- container-->
      </div>
    </form>
</body>
</html>