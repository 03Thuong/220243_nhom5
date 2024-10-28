<?php
include_once("connect.php");

// Lấy mã sinh viên từ URL
if (isset($_GET['ma'])) {
    $maSV = $_GET['ma'];

    // Truy vấn để lấy thông tin sinh viên
    $sql = "SELECT * FROM sinhvien WHERE maSV = '$maSV'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hoLot = $row['hoLot'];
        $tenSV = $row['tenSV'];
        $maLop = $row['maLop'];
    } else {
        echo "Không tìm thấy sinh viên!";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xóa ảnh sinh viên trước
    $sql_delete_image = "DELETE FROM image WHERE maSV = '$maSV'";
    $conn->query($sql_delete_image);

    // Xóa taikhoan sinh viên trước
    $sql_delete_tk = "DELETE FROM taikhoan WHERE maSV = '$maSV'";
    $conn->query($sql_delete_tk);

    // Sau đó xóa sinh viên
    $sql = "DELETE FROM sinhvien WHERE maSV = '$maSV'";
    if ($conn->query($sql) === TRUE) {
        echo "Xóa thành công!";
        header("Location: sinhvien.php?maLop=" . $maLop); // Chuyển hướng về trang danh sách sinh viên
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Xóa Sinh Viên</title>
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
            color: #dc3545; 
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Xác Nhận Xóa Sinh Viên</h2>
    <p>Bạn có chắc chắn muốn xóa sinh viên "<?php echo $hoLot . ' ' . $tenSV; ?> - <?php echo $maLop; ?>"" không?</p>
    <form method="POST" action="xoa_sv.php?ma=<?php echo $maSV; ?>">
        <div class="text-center" style="margin-top: 20px;">
            <button type="submit" class="btn btn-danger mx-2">Xóa</button>
            <a href="sinhvien.php?maLop=<?php echo $maLop; ?>" class="btn btn-secondary mx-2">Hủy</a>
        </div>
    </form>
</div>

</body>
</html>
