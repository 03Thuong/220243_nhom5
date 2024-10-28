<?php
session_start();
require_once 'google_client.php';
require_once 'connect.php'; // Kết nối tới cơ sở dữ liệu

// Check if we have an authorization code
if (isset($_GET['code'])) {
    // Exchange the authorization code for an access token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Get user profile info
    $google_service = new Google_Service_Oauth2($client);
    $user_info = $google_service->userinfo->get();

    // Store user info in session
    $_SESSION['user_email'] = $user_info->email;
    $_SESSION['user_name'] = $user_info->name;

    // Lấy thông tin người dùng
    $email = $user_info->email;
    $username = $user_info->name; // Hoặc bạn có thể tạo một username từ email

    // Truy vấn để lấy thông tin từ cơ sở dữ liệu dựa trên email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Nếu không tồn tại, thêm người dùng mới
        $password = password_hash('default_password', PASSWORD_DEFAULT); // Mật khẩu mặc định
        $sql_insert = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        if ($conn->query($sql_insert) === TRUE) {
            // Nếu chèn thành công, lấy thông tin người dùng
            $sql_new_user = "SELECT * FROM users WHERE email = '$email'"; // Truy vấn lại thông tin người dùng mới
            $new_user_result = $conn->query($sql_new_user);
            $user_data = $new_user_result->fetch_assoc();
        } else {
            // Xử lý lỗi khi chèn người dùng mới
            die("Error: " . $conn->error);
        }
    } else {
        // Lấy thông tin người dùng từ kết quả truy vấn
        $user_data = $result->fetch_assoc();
    }

    // Nếu người dùng đã tồn tại hoặc mới được thêm, lấy vai trò
    if (isset($user_data)) {
        $role = $user_data['role'];
        $_SESSION['role'] = $role; // Lưu vai trò vào session

        // Kiểm tra vai trò và chuyển hướng dựa trên vai trò
        if ($role == 'user') {
            // Chuyển hướng đến sv.php nếu vai trò là 'user'
            header("Location: sinhvien.php");
        } elseif ($role == 'admin') {
            // Chuyển hướng đến lop.php nếu vai trò là 'admin'
            header("Location: lophoc.php");
        }
        exit(); // Đảm bảo không có thêm mã nào được thực thi sau header
    }
}
?>
