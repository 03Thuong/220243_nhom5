<?php
include_once("connect.php");
session_start();
// Kiểm tra role một lần duy nhất ở đầu file
if (!isset($_SESSION['role'])) {
  header("Location: login.php");
  exit();
}

$role = $_SESSION['role'];
$maLop = isset($_GET['maLop']) ? $_GET['maLop'] : '';

// Tiếp tục với logic chính của trang
if ($role == 'admin') {
  $sql = "SELECT * FROM sinhvien, lophoc 
          WHERE sinhvien.maLop = lophoc.maLop 
          AND sinhvien.maLop = '$maLop'";
} else {
  $sql = "SELECT * FROM sinhvien, lophoc 
          WHERE sinhvien.maLop = lophoc.maLop";
}
$result = $conn->query($sql);


// Khởi tạo biến để lưu sinh viên vừa thêm
$addedStudent = '';
if (isset($_GET['addedStudent'])) {
  $addedStudent = urldecode($_GET['addedStudent']);
}
;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>QUẢN LÝ SINH VIÊN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
      max-width: 1200px;
    }

    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 30px;
    }

    .btn-primary {
      width: 120px;
      /* Điều chỉnh chiều rộng phù hợp */
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

    .btn-edit,
    .btn-delete {
      padding: 5px 10px;
      font-size: 14px;
      border-radius: 5px;
    }

    .btn-edit {
      background-color: #ffc107;
      color: #fff;
    }

    .btn-edit:hover {
      background-color: #e0a800;
    }

    .btn-delete {
      background-color: #dc3545;
      color: #fff;
    }

    .btn-delete:hover {
      background-color: #c82333;
    }

    .text-center {
      text-align: center;
    }

    .search-button {
      padding: 10px 15px;
      border: none;
      background-color: #007bff;
      color: white;
      border-radius: 5px;
      margin-left: 10px;
      font-size: 16px;
    }

    .search-button:hover {
      background-color: #0056b3;
    }

    .search-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
      position: relative;
    }

    .search-input {
      width: 600px;
      padding: 5px;
      border: 1px solid #007bff;
      border-radius: 5px;
      font-size: 16px;
      margin-bottom: 0;
      /* Loại bỏ khoảng cách dưới */
      box-sizing: border-box;
      /* Đảm bảo padding và border nằm trong kích thước */
    }

    .livesearch {
      display: none;
      position: absolute;
      z-index: 1;
      width: 600px;
      top: calc(100% + 10px);
      max-height: 200px;
      overflow-y: auto;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border: 1px solid #007bff;
      border-radius: 5px;
      margin-top: 0;
      box-sizing: border-box;
      margin-right: 120px;
    }
  </style>
</head>

<body>

  <div class="container">
    <h2> DANH SÁCH SINH VIÊN LỚP <?php echo $maLop; ?> </h2>
    <?php
    if ($addedStudent) {
      echo "<div class='alert alert-success'>Sinh viên <strong>$addedStudent</strong> đã được thêm thành công!</div>";
    }
    // Form tìm kiếm
    if ($role == 'admin') {
      // Form tìm kiếm cho admin
      echo '<form method="GET" class="mb-3">
                <input type="hidden" name="maLop" value="' . $maLop . '">
                <div class="search-container">
                    <input type="text" name="search" class="search-input" placeholder="Tìm kiếm sinh viên..."
                        value="' . (isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '') . '">
                    <button class="search-button"><i class="fa fa-search"></i> Tìm kiếm</button>
                </div>
                </form>';
    } else {
      // Form tìm kiếm cho user với AJAX
      echo '<form method="GET" class="mb-3">
                <div class="search-container">
                    <input type="text" name="search" class="search-input" placeholder="Tìm kiếm sinh viên..."
                        onkeyup="showResult(this.value)">
                    <div id="livesearch" class="livesearch"></div>
                    <button class="search-button"><i class="fa fa-search"></i> Tìm kiếm</button>
                </div>
                </form>';
    }

    // Xử lý truy vấn
    $search = '';
    if (isset($_GET['search'])) {
      $search = trim($_GET['search']);
    }


    // Truy vấn dựa trên vai trò
    if ($role == 'admin') {
      $sql .= " AND sinhvien.maLop = '$maLop'";
    }

    // Thêm điều kiện tìm kiếm nếu có
    if ($search) {
      $sql .= " AND (sinhvien.hoLot LIKE '%$search%' 
          OR sinhvien.tenSV LIKE '%$search%' 
          OR sinhvien.maSV LIKE '%$search%' 
          OR sinhvien.gioiTinh LIKE '%$search%')";
    }

    // Nếu là user, thêm điều kiện phân trang
    if ($role != 'admin') {
      $limit = 5;
      $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
      $offset = ($page - 1) * $limit;

      // Đếm tổng số sinh viên
      $count_result = $conn->query($sql);
      $total_students = $count_result->num_rows;
      $total_pages = ceil($total_students / $limit);

      // Thêm LIMIT và OFFSET vào câu truy vấn
      $sql .= " LIMIT $limit OFFSET $offset";
    }


    $result = $conn->query($sql);

    // Hiển thị kết quả
    if ($result->num_rows > 0) {
      echo "<table class='table table-hover table-bordered mt-3'>";
      echo "<thead><tr><th>Mã SV</th><th>Họ Lót</th><th>Tên SV</th><th>Ngày Sinh</th><th>Giới Tính</th><th>Mã Lớp</th>";

      if ($role == 'admin') {
        echo "<th>Sửa</th><th>Xóa</th>";
      } else {
        echo "<th>Sửa</th>";
      }

      echo "</tr></thead><tbody>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href='thongtinsv.php?maSV=" . $row["maSV"] . "'>" . $row["maSV"] . "</a></td>";
        echo "<td>" . $row["hoLot"] . "</td>";
        echo "<td>" . $row["tenSV"] . "</td>";
        echo "<td>" . $row["ngaySinh"] . "</td>";
        echo "<td>" . $row["gioiTinh"] . "</td>";
        echo "<td>" . $row["maLop"] . " - " . $row["tenLop"] . "</td>";
        echo "<td><a class='btn btn-edit' href='sua_sv.php?ma=" . $row["maSV"] . "'><i class='fa fa-edit'></i></a></td>";

        if ($role == 'admin') {
          echo "<td><a class='btn btn-delete' href='xoa_sv.php?ma=" . $row["maSV"] . "'><i class='fa fa-trash'></i></a></td>";
        }

        echo "</tr>";
      }
      echo "</tbody></table>";

      // Hiển thị phân trang cho user
      if ($role != 'admin') {
        echo "<nav class='mt-3'><ul class='pagination justify-content-center'>";
        for ($i = 1; $i <= $total_pages; $i++) {
          $active = $i == $page ? 'active' : '';
          echo "<li class='page-item $active'><a class='page-link' href='?page=$i&search=$search'>$i</a></li>";
        }
        echo "</ul></nav>";
      }
    } else {
      echo "<p class='text-center'>Không có sinh viên nào được tìm thấy.</p>";
    }


    $conn->close();
    ?>
    <div class="text-center">
      <?php if (isset($role) && $role == 'admin'): ?>
        <!-- Chỉ hiển thị nút Thêm mới và Quay lại cho admin -->
        <a class="btn btn-primary" href="them_sv.php?maLop=<?php echo $maLop; ?>">
          <i class="fa fa-plus"></i> Thêm mới
        </a>
        <a class="btn btn-primary" href="lophoc.php" style="margin-left: 20px;">
          <i class="fa fa-undo"></i> Quay lại
        </a>
      <?php endif; ?>
      <a class="btn btn-primary" href="logout.php" style="margin-left: 20px;"><i class="fas fa-sign-out-alt"></i> Đăng
        xuất</a>
    </div>


  </div>
  <script>
    // Ẩn thông báo sau 10 giây
    setTimeout(function () {
      var alertBox = document.querySelector('.alert');
      if (alertBox) {
        alertBox.style.display = 'none';
      }
    }, 5000);

    // AJAX 
    function showResult(str) {
      if (str.length == 0) {
        document.getElementById("livesearch").innerHTML = "";
        document.getElementById("livesearch").style.border = "0px";
        document.getElementById("livesearch").style.display = "none"; // Ẩn theo mặc định
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("livesearch").innerHTML = this.responseText;
          document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
          document.getElementById("livesearch").style.display = "block"; // Hiển thị khi có kết quả
        }
      }
      xmlhttp.open("GET", "livesearch.php?q=" + str, true);
      xmlhttp.send();
    }

  </script>




</body>

</html>