<?php
include_once("connect.php");

// Lấy mã lớp từ URL
$maLop = isset($_GET['maLop']) ? $_GET['maLop'] : '';

// Viết câu truy vấn để lấy danh sách sinh viên theo mã lớp
$sql_tlop = "SELECT * FROM lophoc WHERE maLop = '$maLop'";
$result_tlop = $conn->query($sql_tlop);
if ($result_tlop->num_rows > 0) {
  $row = $result_tlop->fetch_assoc();
  $tenLop = $row['tenLop']; // Lớp hiện tại của sinh viên
} else {
  echo "Không tìm thấy lop!";
  exit;
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <title>Form SINH VIÊN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #FFEFD5;
    }

    .container {
      margin-top: 50px;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 600px;
    }

    h2 {
      color: #007bff;
      text-align: center;
      margin-bottom: 30px;
    }

    label {
      font-size: 1.2rem;
      font-weight: bold;
    }

    .form-control {
      border-radius: 5px;
      border: 1px solid #ced4da;
    }

    .btn-primary {
      width: 150px;
      /* Điều chỉnh chiều rộng phù hợp */
      margin: 0 auto 20px auto;
      padding: 5px 10px;
      font-size: 16px;
      font-weight: bold;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .text-center {
      text-align: center;
    }
  </style>

</head>

<body>

  <div class="container">
    <h2>QUẢN LÝ THÔNG TIN SINH VIÊN</h2>
    <form action="xuly_themsv.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="masv">Mã sinh viên:</label>
        <input type="text" class="form-control" id="masv" placeholder="Nhập mã sinh viên" name="txtMaSV" required>
      </div>
      <div class="form-group">
        <label for="holot">Họ lót:</label>
        <input type="text" class="form-control" id="holot" placeholder="Nhập họ lót" name="txtHoLot" required>
      </div>
      <div class="form-group">
        <label for="tensv">Tên sinh viên:</label>
        <input type="text" class="form-control" id="tensv" placeholder="Nhập tên sinh viên" name="txtTenSV" required>
      </div>
      <div class="form-group">
        <label for="ngaysinh">Ngày sinh:</label>
        <input type="date" class="form-control" id="ngaysinh" name="txtNgaySinh">
      </div>
      <div class="form-group">
        <label for="gioitinh">Giới tính:</label>
        <select class="form-control" id="gioitinh" name="txtGioiTinh">
          <option value="Nam">Nam</option>
          <option value="Nữ">Nữ</option>
        </select>
      </div>
      <div class="form-group">
        <label for="maLop">Mã Lớp - Tên Lớp:</label>
        <input type="text" class="form-control" id="maLop" name="maLop" value="<?php echo $maLop . ' - ' . $tenLop; ?>"
          readonly>
      </div>

      <div class="form-group">
        <label for="Streetname">Tên đường, Số nhà:</label>
        <input type="text" id="Streetname" name="txtStreetname" class="form-control" placeholder="Tên đường, Số nhà">
      </div>

      <div class="form-group">
        <label for="province">Tỉnh/Thành Phố:</label>
        <select id="province" name="txtProvince" class="form-control" >
          <option value="">Chọn tỉnh/thành phố</option>
          <!-- Options will be populated by address.js -->
        </select>
      </div>

      <div class="form-group">
        <label for="district">Quận/Huyện:</label>
        <select id="district" name="txtDistrict" class="form-control">
          <option value="">Chọn quận/huyện</option>
          <!-- Options will be populated by address.js -->
        </select>
      </div>

      <div class="form-group">
        <label for="ward">Xã/Phường:</label>
        <select id="ward" name="txtWard" class="form-control">
          <option value="">Chọn xã/phường</option>
          <!-- Options will be populated by address.js -->
        </select>
      </div>
       <!--lưu full địa chỉ -->
      <input type="hidden" id="fullAddress" name="txtFullAddress">

      <div class="form-group">
        <label for="image">Ảnh sinh viên:</label>
        <input type="file" class="form-control" id="image" name="image">
      </div>



      <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</button>
        <a class="btn btn-primary" href="sinhvien.php?maLop=<?php echo $maLop; ?>" style="margin-left: 20px;"><i
            class="fa fa-undo"></i> Quay lại</a>
      </div>

    </form>
  </div>
  <!-- Include Axios library -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <!-- Include your custom JavaScript file -->
  <script src="address.js"></script>

</body>

</html>