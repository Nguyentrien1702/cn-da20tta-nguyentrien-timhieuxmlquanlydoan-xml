<?php
    include("header-sinhvien.php")
?>
<style>
#form {
    width: 50%;
    margin: auto;
}

h2 {
    border-radius: 5px;
    text-align: center;
    padding: 20px !important;
    font-size: 40px;
    font-weight: bold;
    color: blue;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.div-flex {
    display: flex;
}

label {
    font-size: 15px;
}

table {
    width: 80%;
}

th,
td {
    padding: 8px;
    text-align: left;
}

label {
    display: block;
    text-align: right;
    padding-right: 5px;
}

input {
    width: calc(100% - 15px);
    box-sizing: border-box;
    border-radius: 7px;
}

.capnhatmatkhau {
    background-color: cornflowerblue;
    font-size: 15px;
    color: white;
    padding: 7px;
    border-radius: 7px;
    width: 200px;
}

.capnhatmatkhau:hover {
    background-color: green;
}

#btn {
    text-align: right;
}
</style>

<?php
// Kiểm tra xem có tham số URL "Tentaikhoan" được truyền
if (isset($_GET['tentaikhoan']) && isset($_GET['p'])) {
    $tentk = $_GET['tentaikhoan'];
    $loi = $_GET['p'];
} else {
    $tentk = "";
    $loi = "";
}
?>

<!-- Form đổi mật khẩu -->
<div id="form">
    <h2 class="w3-container">Đổi mật khẩu</h2>

    <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_doimatkhau_sv.php" method="post">
        <table>
            <tr>
                <td><label for="tentk">Tên tài khoản:</label></td>
                <td><input class="w3-input w3-border" type="text" id="tentk" name="txttentk" placeholder="Tên tài khoản"
                        value="<?php echo $tentk; ?>" required></td>
            </tr>
            <tr>
                <td><label for="hoten">Họ và tên:</label></td>
                <td><input class="w3-input w3-border" type="text" id="hoten" name="txthoten" placeholder="Họ và tên"
                        required></td>
            </tr>
            <tr>
                <td><label for="matkhaumoi">Mật khẩu mới:</label></td>
                <td><input class="w3-input w3-border" type="password" id="matkhaumoi" name="txtmatkhaumoi"
                        placeholder="Mật khẩu mới" required></td>
            </tr>
            <tr>
                <td><label for="xacnhanmatkhau">Xác nhận mật khẩu:</label></td>
                <td><input class="w3-input w3-border" type="password" id="xacnhanmatkhau" name="txtxacnhanmatkhau"
                        placeholder="Xác nhận mật khẩu" required>
                    <p id="alert" style="color: red; padding-left: 10px"><?php echo $loi; ?> </p>
                </td>

            </tr>
            <tr>
                <td colspan="2" id="btn"><button class='capnhatmatkhau' type='submit' name='sbmcapnhat'>Cập nhật mật
                        khẩu</button>
                </td>
            </tr>
        </table>
    </form>
</div>


<script>
// Lấy tham chiếu đến các trường input và thẻ p "alert"
const txtTentaikhoan = document.getElementById("txttentk");
const txthoten = document.getElementById("txthoten");
const txtmatkhau = document.getElementById("txtmatkhaumoi");
const txtmkmoi = document.getElementById("txtxacnhanmatkhau");
const alertP = document.getElementById("alert");

// Sử dụng sự kiện click để ẩn thẻ "alert" khi một trong hai trường input được click
txtTentaikhoan.addEventListener("click", function() {
    alertP.style.display = "none";
});
txthoten.addEventListener("click", function() {
    alertP.style.display = "none";
});

txtmatkhau.addEventListener("click", function() {
    alertP.style.display = "none";
});
txtmkmoi.addEventListener("click", function() {
    alertP.style.display = "none";
});

function ssmatkhau() {
    if (txtmatkhau.value !== txtmkmoi.value) {
        alertP.textContent = "xác nhận mật khẩu chưa đúng";
        alertP.style.display = "block";
        txtmkmoi.nodeValue = "";
        return false;
    } else return true;
}
</script>

<?php
  include("footer-sinhvien.php")
?>