<!DOCTYPE html>
<html lang="en">
<head>
  <title>QUẢN LÝ THÔNG TIN SINH VIÊN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <style>
    .student-info {
      display: flex;
      align-items: center;
      justify-content: center; /* Căn giữa */
    }
    .student-info img {
      max-width: 300px;
      max-height: 400px;/* Tăng kích thước ảnh */
      margin-right: 80px; /* Tăng khoảng cách bên phải ảnh */
    }
    .student-details {
      max-width: 800px;
      text-align: left; /* Căn trái cho nội dung */
    }

    body {
      background-color: #FFEFD5;
    }

    .container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
      max-width: 1000px;
    }

    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 30px;
    }

    .btn-primary {
      width: 120px; /* Điều chỉnh chiều rộng phù hợp */
      margin: 0 auto 20px auto;
      padding: 5px 10px;
      font-size: 16px;
      font-weight: bold;
    }

    table {
      width: 100%;
    }

    table th {
      background-color: #007bff;
      color: #fff;
      padding: 12px;
      text-align: center;
    }

    table td {
      padding: 12px;
      text-align: center;
    }

    table tr:hover {
      background-color: #f1f1f1;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container">
<?php
include_once("connect.php");

if (isset($_GET['maSV'])) {
    $maSV = $_GET['maSV'];

    // Truy vấn thông tin sinh viên
    $sql = "SELECT * FROM sinhvien WHERE maSV = '$maSV'";
    $result = $conn->query($sql);



    // Truy vấn ảnh mới nhất
    $sql_image = "SELECT url FROM image WHERE maSV = '$maSV' ORDER BY id_image DESC LIMIT 1"; // Giả sử có cột id trong bảng image để xác định ảnh mới nhất
    $result_image = $conn->query($sql_image);

    if ($result->num_rows > 0) {
        // Lấy thông tin sinh viên
        $student = $result->fetch_assoc();
        $image = $result_image->fetch_assoc();

        // Kiểm tra xem ảnh có tồn tại không, nếu không thì sử dụng ảnh mặc định
        if ($image) {
          $imageUrl = $image['url'];
      } else {
          $imageUrl = 'image/avatar.png'; // avatar.png là ảnh mặc định
      }
      
        ?>
        
        <h2>Thông Tin Sinh Viên</h2>
        <div class="student-info">
            <img src="<?php echo $imageUrl; ?>" alt="Student Image">
            <div class="student-details">
                <p><strong>Mã SV:</strong> <?php echo $maSV; ?></p>
                <p><strong>Họ và Tên:</strong> <?php echo $student['hoLot'] . ' ' . $student['tenSV']; ?></p>
                <p><strong>Ngày Sinh:</strong> <?php echo $student['ngaySinh']; ?></p>
                <p><strong>Giới Tính:</strong> <?php echo $student['gioiTinh'] == '1' ? 'Nam' : 'Nữ'; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $student['diaChi']; ?></p>
                <p><strong>Mã Lớp:</strong> <?php echo $student['maLop']; ?></p>
            </div>
        </div>

        <?php
    } else {
        echo "<p class='text-center'>Không tìm thấy thông tin sinh viên.</p>";
    }
} else {
    echo "<p class='text-center'>Vui lòng cung cấp mã sinh viên.</p>";
}

$conn->close();
?>

</div>

</body>
</html>
