
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"/>
<form action="Xuly/Xuly_Dangnhap.php" method="post">
    <div>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row border rounded-4 p-3 bg-white shadow box-area">
              <!-- left-->
              <div class="col-md-5 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="padding-right: 30px; padding-left: 25px;">
                <div class="fictured-image">
                  <img src="images/logotvu.png" class="img-fluid" style="max-width: 250px"/>
                </div>
              </div>
              <!-- right-->
              <div class="col-md-7 right-box">
                <div class="row align-items-center">
                    <div class="header-text">
                      <h3 class="mb-4"><strong>Đăng nhập</strong></h3>
                      <!-- Tên đăng nhập-->
                      <div class="input-group mb-3">
                        <input type="text" name="txtTentaikhoan" ID="txtTentaikhoan" class="form-control form-control-lg bg-light fs-6" placeholder="Tên đăng nhập"/>
                      </div>
                      <!-- Mật khẩu-->
                      <div class="input-group mb-3">
                        <input type="password" name="txtMatkhau" ID="txtMatkhau" class="form-control form-control-lg bg-light fs-6" placeholder="Mật khẩu"/>
                      </div>
                      <!-- Checkbox-->
                      <div class="input-group mb-3 d-flex justify-content-between">
                        <div class="forgot">
                          <a href="#">Quên mật khẩu?</a>
                        </div>
                      </div>
                
                      <div class="input-group mb-3">
                        <input type="submit" name= "sbDangnhap" class="btn btn-lg btn-primary w-100 fs-6 p-1" value="Đăng nhập"/>
                      </div>
                    </div>
                </div>
              </div><!-- right-box-->
            </div><!-- row box-area-->
          </div><!-- container-->
      </div>
</form>
