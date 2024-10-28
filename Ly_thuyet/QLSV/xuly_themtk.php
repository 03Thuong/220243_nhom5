<?php
include_once("connect.php");

// Khởi tạo biến
$tenTK = $password ="";

// Kiểm tra và lấy dữ liệu từ form
if (!empty($_POST["txtTenTK"]) && !empty($_POST["txtPass"])) {
    $tenTK = $_POST["txtTenTK"];
    $password = $_POST["txtPass"];
        
    // Kiểm tra xem username đã tồn tại chưa
    $sql_check = "SELECT * FROM users WHERE username = '$tenTK'";
    $result_check = $conn->query($sql_check);
    
    if ($result_check->num_rows > 0) {
        echo "<script>alert('Tài khoản đã tồn tại.'); window.location.href = 'Login.php';</script>";
        exit;
    }
       //thực hiện truy vấn INSERT
        $sql = "INSERT INTO users (username, password) VALUES ('$tenTK', '$password')";
         
        // Thực thi truy vấn
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Đăng ký thành công.'); window.location.href = 'Login.php';</script>";
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }


// Đóng kết nối
$conn->close();
?>