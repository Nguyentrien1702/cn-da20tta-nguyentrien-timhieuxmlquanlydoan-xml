<?php
session_start();
require("Xuly_XML/Xuly_taikhoan.php");
// Hàm kiểm tra thông tin đăng nhập
function kiemTraDangNhap($username, $password) {
    // Đọc tệp XML
    $xml = simplexml_load_file('../QuanlyXML/Taikhoan.xml');
    foreach ($xml->taikhoan as $taikhoan) {
        if ((string) $taikhoan['tentaikhoan'] === $username) {
            if (/*password_verify( $password, (string) $taikhoan->matkhau)*/ (string) $taikhoan->matkhau=== md5($password)){
                $_SESSION["allow"] = true;
                return (string) $taikhoan->loaitaikhoan;
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
    $_SESSION["user"] = $username;

    $result = kiemTraDangNhap($username, $password);

    if ($result === "Admin") {
        // Đăng nhập thành công cho tài khoản Admin
        header("Location: ../Giaodien/Admin/Giaodien_admin.php");
        $_SESSION["tennguoidung"] = "admin";
        exit;
    } elseif ($result === "Sinhvien") {
        $xml = simplexml_load_file("../QuanlyXML/Sinhvien.xml");

        foreach ($xml->sinhvien as $sinhvien) {
            if ((string)$sinhvien['mssv'] === $username) {
                // Cập nhật Giảng viên
                $tensinhvien = $sinhvien->tensinhvien;
                break;
            }
        }
        // Tách tên thành mảng các từ
        $mang_ten = explode(" ", $tensinhvien);

        // Lấy phần cuối (họ cuối)
        $ho_cuoi = end($mang_ten);
        // Đăng nhập thành công cho tài khoản Sinhvien
        header("Location: ../Giaodien/Sinhvien/index_sinhvien.php");
        $_SESSION["tennguoidung"] = $ho_cuoi;
        exit;
        } elseif ($result === "Giangvien") {
            $xml = simplexml_load_file("../QuanlyXML/Giangvien.xml");

            foreach ($xml->giangvien as $giangvien) {
                if ((string)$giangvien['msgv'] === $username) {
                    // Cập nhật Giảng viên
                    $tengiangvien = $giangvien->tengiangvien;
                    break;
                }
            }
            // Tách tên thành mảng các từ
            $mang_ten = explode(" ", $tengiangvien);

            // Lấy phần cuối (họ cuối)
            $ho_cuoi = end($mang_ten);
            // Đăng nhập thành công cho tài khoản Giangvien
            header("Location: ../Giaodien/Giangvien/index_giangvien.php");
            $_SESSION["tennguoidung"] = $ho_cuoi;
            exit;
            } else {
                // Đăng nhập thất bại
                header("Location: ../index.php?txtTentaikhoan=" . urlencode($username). "&p=" . urlencode($result));
                exit;
            }
}

?>

