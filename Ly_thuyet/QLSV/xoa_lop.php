<?php
include_once("connect.php");

// Lấy mã lớp từ URL
if (isset($_GET['ma'])) {
    $maLop = $_GET['ma'];

    // Truy vấn để lấy thông tin lớp học
    $sql = "SELECT * FROM lophoc WHERE maLop = '$maLop'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tenLop = $row['tenLop'];
    } else {
        echo "Không tìm thấy lớp học!";
        exit;
    }
}

    // Xử lý khi người dùng xác nhận xóa
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Bước 1: Xóa tài khoản của sinh viên
    $deleteAccountsSql = "DELETE FROM taikhoan WHERE maLop = '$maLop'";

        if ($conn->query($deleteAccountsSql) === TRUE) {
            // Bước 2: Xóa sinh viên thuộc lớp này
            $deleteStudentsSql = "DELETE FROM sinhvien WHERE maLop = '$maLop'";
    
                if ($conn->query($deleteStudentsSql) === TRUE) {
                    // Bước 3: Xóa lớp học
                    $deleteClassSql = "DELETE FROM lophoc WHERE maLop = '$maLop'";
        
                    if ($conn->query($deleteClassSql) === TRUE) {
                        echo "Xóa lớp học và sinh viên thành công!";
                        header("Location: lophoc.php");
                        exit;
                    } else {
                            echo "Lỗi: " . $conn->error;
                        }
                } else {
                    echo "Lỗi khi xóa sinh viên: " . $conn->error;
                    }
        } else {
            echo "Lỗi khi xóa tài khoản: " . $conn->error;
            }

    }

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Xóa Lớp Học</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #FFEFD5;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            max-width: 700px;
        }
        h2 {
            text-align: center;
            color: #dc3545; /* Màu đỏ cho tiêu đề xóa */
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Xác Nhận Xóa Lớp Học</h2>
    <p>Bạn có chắc chắn muốn xóa lớp học "<?php echo $tenLop; ?>" không?</p>
    <form method="POST" action="xoa_lop.php?ma=<?php echo $maLop; ?>">
        <div class="text-center" style="margin-top: 20px;">
            <button type="submit" class="btn btn-danger mx-2">Xóa</button>
            <a href="lophoc.php" class="btn btn-secondary mx-2">Hủy</a>
        </div>
    </form>
</div>

</body>
</html>
