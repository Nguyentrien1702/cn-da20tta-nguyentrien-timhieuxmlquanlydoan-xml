<?php
session_start();
// Hàm kiểm tra thông tin đăng nhập
function kiemTraDangNhap($username, $password) {
    // Đọc tệp XML
    $xml = simplexml_load_file('../QuanlyXML/Taikhoan.xml');

    foreach ($xml->Taikhoan as $taikhoan) {
        if ((string) $taikhoan['Tentaikhoan'] === $username) {
            if ((string) $taikhoan->Matkhau === $password) {
                $_SESSION["allow"] = true;
                return (string) $taikhoan->Loaitaikhoan;
            } else {
                return "Sai mật khẩu";
            }
        }
    }
    return "Tài khoản không tồn tại";
}

if (isset($_POST['sbDangnhap'])) {
    $username = $_POST['txtTentaikhoan'];
    $password = $_POST['txtMatkhau'];

    $result = kiemTraDangNhap($username, $password);

    if ($result === "Admin") {
        // Đăng nhập thành công cho tài khoản Admin
        header("Location: ../Giaodien/Admin/Giaodien_admin.php");
        $_SESSION["tennguoidung"] = "admin";
        exit;
    } elseif ($result === "Sinhvien") {
        // Đăng nhập thành công cho tài khoản Sinhvien
        header("Location: ../Giaodien/Sinhvien/index_sinhvien.php");
        $_SESSION["tennguoidung"] = "Sinh viên";
        exit;
        } elseif ($result === "Giangvien") {
            // Đăng nhập thành công cho tài khoản Giangvien
            header("Location: ../Giaodien/Giangvien/index_giangvien.php");
            $_SESSION["tennguoidung"] = "Giảng viên";
            exit;
            } else {
                // Đăng nhập thất bại
                header("Location: ../index.php?txtTentaikhoan=" . urlencode($username). "&p=" . urlencode($result));
                exit;
            }
}

?>

