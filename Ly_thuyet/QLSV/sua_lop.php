<?php
include_once("connect.php");

// Lấy mã lớp từ URL
if (isset($_GET['ma'])) {
  $maLop = $_GET['ma'];

  // Truy vấn để lấy thông tin lớp học hiện tại
  $sql = "SELECT * FROM lophoc WHERE maLop = '$maLop'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tenLop = $row['tenLop'];
    $ghiChu = $row['ghiChu']; // Lấy ghi chú
  } else {
    echo "Không tìm thấy lớp học!";
    exit;
  }
}

// Xử lý khi người dùng gửi form sửa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $maLop = $_POST['maLop'];
  $tenLop = $_POST['tenLop'];
  $ghiChu = $_POST['ghiChu']; // Nhận ghi chú từ form

  // Cập nhật thông tin lớp học
  $sql = "UPDATE lophoc SET tenLop = '$tenLop', ghiChu = '$ghiChu' WHERE maLop = '$maLop'";

  if ($conn->query($sql) === TRUE) {
    echo "Cập nhật thành công!";
    header("Location: lophoc.php"); // Chuyển hướng về trang chính
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
  <title>Sửa Lớp Học</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #FFEFD5;
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
      max-width: 600px;
    }

    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 30px;
    }

    .btn-primary {
      display: block;
      margin: 20px auto;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Sửa Thông Tin Lớp Học</h2>
  <form method="POST" action="sua_lop.php">
    <div class="form-group">
      <label for="maLop">Mã Lớp</label>
      <input type="text" class="form-control" id="maLop" name="maLop" value="<?php echo $maLop; ?>" readonly>
    </div>

    <div class="form-group">
      <label for="tenLop">Tên Lớp</label>
      <input type="text" class="form-control" id="tenLop" name="tenLop" value="<?php echo $tenLop; ?>" required>
    </div>
    <div class="form-group">
      <label for="ghiChu">Ghi Chú</label>
      <input type="text" class="form-control" id="ghiChu" name="ghiChu" value="<?php echo $ghiChu; ?>" >
    </div>
    <button type="submit" class="btn btn-primary">
      <i class="fa fa-sync"></i> Cập Nhật
    </button>

  </form>
</div>

</body>
</html>
