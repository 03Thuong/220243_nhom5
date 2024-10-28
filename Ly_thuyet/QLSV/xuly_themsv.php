<?php
include_once('connect.php');

// Lấy dữ liệu từ form
$maSV = $hoLot = $tenSV = $ngaySinh = $gioiTinh = $maLop = "";
if (!empty($_POST["txtMaSV"]) && !empty($_POST["txtHoLot"]) && !empty($_POST["txtTenSV"])) {
    $maSV = htmlspecialchars($_POST["txtMaSV"]);
    $hoLot = htmlspecialchars($_POST["txtHoLot"]);
    $tenSV = htmlspecialchars($_POST["txtTenSV"]);
    $ngaySinh = $_POST["txtNgaySinh"];
    $gioiTinh = $_POST["txtGioiTinh"];
    $maLop = $_POST["maLop"]; // Lấy mã lớp từ form
    $maLop = explode(' - ', $maLop)[0]; // Tách để chỉ lấy phần mã lớp
    $diaChi = $_POST['txtFullAddress'];
    


    // Kiểm tra mã sinh viên phải là một số
    if (!is_numeric($maSV)) {
        echo "<script>alert('Mã sinh viên phải là một số.'); window.history.back();</script>";
        exit(); // Dừng thực thi nếu mã sinh viên không hợp lệ
    }

    // Kiểm tra mã sinh viên đã tồn tại
    $sqlCheck = "SELECT maSV FROM sinhvien WHERE maSV = '$maSV'";
    $resultCheck = $conn->query($sqlCheck);
    if ($resultCheck->num_rows > 0) {
        echo "<script>alert('Mã sinh viên đã tồn tại. Vui lòng chọn mã khác.'); window.history.back();</script>";
        exit(); // Dừng thực thi nếu mã sinh viên đã tồn tại
    }

    // Kiểm tra ngày sinh lớn hơn 18 tuổi
    $currentYear = date("Y");
    $yearOfBirth = date("Y", strtotime($ngaySinh));
    if (($currentYear - $yearOfBirth) < 18) {
        echo "<script>alert('Sinh viên phải lớn hơn 18 tuổi.'); window.history.back();</script>";
        exit(); // Dừng thực thi nếu sinh viên chưa đủ tuổi
    }

    // Biến kiểm tra trạng thái tải lên
    $uploadOk = 1;

    // Xử lý tải lên hình ảnh nếu có
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "uploads/"; // Thư mục lưu trữ hình ảnh
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)); // Lấy định dạng hình ảnh
        $target_file = $target_dir . basename($_FILES["image"]["name"]); // Đường dẫn hình ảnh

        // Kiểm tra kích thước tệp
        if ($_FILES["image"]["size"] > 500000) {
            echo "<script>alert('Xin lỗi, tệp của bạn quá lớn.'); window.history.back();</script>";
            $uploadOk = 0; // Đặt trạng thái tải lên thành 0
        }

        // Cho phép các định dạng tệp nhất định
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<script>alert('Xin lỗi, chỉ cho phép các tệp JPG, JPEG, PNG & GIF.'); window.history.back();</script>";
            $uploadOk = 0; // Đặt trạng thái tải lên thành 0
        }

        // Kiểm tra nếu tệp đã tồn tại
        if (file_exists($target_file)) {
            echo "<script>alert('Xin lỗi, tệp đã tồn tại.'); window.history.back();</script>";
            $uploadOk = 0; // Đặt trạng thái tải lên thành 0
        }

        // Tải lên tệp
        if ($uploadOk == 1) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "<script>alert('Xin lỗi, đã xảy ra lỗi khi tải lên tệp của bạn.'); window.history.back();</script>";
            }
        }
    } else {
        // Nếu không có hình ảnh được tải lên, thiết lập biến $target_file thành NULL
        $target_file = NULL;
    }

     // Chèn thông tin sinh viên vào bảng sinhvien
     $sql = "INSERT INTO sinhvien (maSV, hoLot, tenSV, ngaySinh, gioiTinh, maLop, diaChi) VALUES ('$maSV', '$hoLot', '$tenSV', '$ngaySinh', '$gioiTinh', '$maLop', '$diaChi')";
    if ($conn->query($sql) === TRUE) {
        // Nếu đã có hình ảnh, chèn thông tin hình ảnh vào bảng image
        if ($target_file) {
            $sql_image = "INSERT INTO image (maSV, url) VALUES ('$maSV', '$target_file')";
            if (!$conn->query($sql_image)) {
                echo "<script>alert('Lỗi: " . $conn->error . "'); window.history.back();</script>";
            }
        }
        // Chuyển hướng về trang danh sách sinh viên
        header("Location: sinhvien.php?maLop=" . $maLop . "&addedStudent=" . urlencode($maSV));
        exit(); // Redirect về trang danh sách sinh viên
    } else {
        echo "<script>alert('Lỗi: " . $conn->error . "'); window.history.back();</script>";
    }

} else {
    echo "<script>alert('Vui lòng điền đầy đủ thông tin.'); window.history.back();</script>";
}

// Đóng kết nối
$conn->close();
?>
