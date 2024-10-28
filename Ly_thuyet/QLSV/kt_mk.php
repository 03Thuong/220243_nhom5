<?php
session_start();
include_once("connect.php");

// Kiểm tra và lấy dữ liệu từ form
if (!empty($_POST["txtTenTK"]) && !empty($_POST["txtPass"])) {
    $tenTK_form = $_POST["txtTenTK"];
    $password_form = $_POST["txtPass"];

    // Truy vấn để lấy thông tin từ cơ sở dữ liệu dựa trên tên tài khoản
    $sql = "SELECT * FROM users WHERE username = '$tenTK_form'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy thông tin người dùng từ kết quả truy vấn
        $row = $result->fetch_assoc();
        $tenTK = $row['username'];
        $password = $row['password'];
        $role = $row['role'];

        // Kiểm tra mật khẩu
        if ($password_form == $password) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['tenTK'] = $tenTK;
            $_SESSION['role'] = $role;

             // Kiểm tra vai trò và chuyển hướng dựa trên vai trò
             if ($role == 'user') {
                // Chuyển hướng đến sv.php nếu vai trò là 'user'
                header("Location: sinhvien.php");
            } elseif ($role == 'admin') {
                // Chuyển hướng đến lop.php nếu vai trò là 'admin'
                header("Location: lophoc.php");
            }
            exit(); // Đảm bảo không có thêm mã nào được thực thi sau header
        } else {
            echo "<script>alert('Tên tài khoản hoặc mật khẩu không đúng.'); window.location.href = 'Login.php';</script>";
        }
    
}
}
// Đóng kết nối
$conn->close();
?>