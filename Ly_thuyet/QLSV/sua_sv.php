<?php
session_start();
include_once("connect.php");

// Check if the user is logged in and has a role
if (!isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}

$role = $_SESSION['role']; // Get user role from session

// Truy vấn để lấy tất cả các lớp học
$sql_all_lop = "SELECT * FROM lophoc";
$result_all_lop = $conn->query($sql_all_lop);

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
        $ngaySinh = $row['ngaySinh'];
        $gioiTinh = $row['gioiTinh'];
        $maLop = $row['maLop'];
        $diaChi = $row['diaChi'];

        // Tách chuỗi thành mảng dựa trên dấu phẩy
        $parts = explode(", ", $diaChi);

        // Gán trực tiếp các phần tử của mảng vào các biến tương ứng
        $streetname = $parts[0];
        $ward = $parts[1];
        $district = $parts[2];
        $province = $parts[3];

    } else {
        echo "<script>alert('Không tìm thấy sinh viên!'); window.history.back();</script>";
        exit();
    }
}

// Xử lý khi người dùng gửi form sửa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST['maSV'];
    $hoLot = $_POST['hoLot'];
    $tenSV = $_POST['tenSV'];
    $ngaySinh = $_POST['ngaySinh'];
    $gioiTinh = $_POST['gioiTinh'];
    $maLop = $_POST['maLop'];

    $diaChi = $_POST['txtFullAddress'];

    // Kiểm tra ngày sinh lớn hơn 18 tuổi
    if ((date("Y") - date("Y", strtotime($ngaySinh))) < 18) {
        echo "<script>alert('Sinh viên phải lớn hơn 18 tuổi.'); window.history.back();</script>";
        exit();
    }

    // Xử lý tải lên hình ảnh
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['name'] != '') {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra kích thước và định dạng tệp
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "<script>alert('Xin lỗi, tệp của bạn quá lớn.'); window.history.back();</script>";
            exit();
        }

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Xin lỗi, chỉ cho phép các tệp JPG, JPEG, PNG & GIF.'); window.history.back();</script>";
            exit();
        }

        // Kiểm tra nếu tệp đã tồn tại
        if (file_exists($target_file)) {
            echo "<script>alert('Xin lỗi, tệp đã tồn tại.'); window.history.back();</script>";
            exit();
        }

        // Tải lên tệp
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Cập nhật thông tin sinh viên
            $sqlUpdate = "UPDATE sinhvien SET hoLot = '$hoLot', tenSV = '$tenSV', ngaySinh = '$ngaySinh', gioiTinh = '$gioiTinh', diaChi = '$diaChi', maLop = '$maLop' WHERE maSV = '$maSV'";
            if ($conn->query($sqlUpdate) === TRUE) {
                // Thêm ảnh mới vào bảng image
                $sql_image = "INSERT INTO image (maSV, url) VALUES ('$maSV', '$target_file')";
                if ($conn->query($sql_image) === TRUE) {
                    if ($role == 'user') {
                        echo "<script>alert('Cập nhật thành công!'); window.location.href='sinhvien.php?';</script>";
                    } else {
                        echo "<script>alert('Cập nhật thành công!'); window.location.href='sinhvien.php?maLop=" . $maLop . "';</script>";
                    }
                } else {
                    echo "<script>alert('Lỗi khi thêm ảnh vào bảng: " . $conn->error . "'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Lỗi: " . $conn->error . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Lỗi trong việc upload ảnh.'); window.history.back();</script>";
        }
    } else {
        // Nếu không upload ảnh mới, chỉ cập nhật thông tin
        $sqlUpdate = "UPDATE sinhvien SET hoLot = '$hoLot', tenSV = '$tenSV', ngaySinh = '$ngaySinh', gioiTinh = '$gioiTinh', diaChi = '$diaChi', maLop = '$maLop' WHERE maSV = '$maSV'";

        if ($conn->query($sqlUpdate) === TRUE) {
            if ($role == 'user') {
                echo "<script>alert('Cập nhật thành công!'); window.location.href='sinhvien.php';</script>";
            } else {
                echo "<script>alert('Cập nhật thành công!'); window.location.href='sinhvien.php?maLop=" . $maLop . "';</script>";
            }
        } else {
            echo "<script>alert('Lỗi: " . $conn->error . "'); window.history.back();</script>";
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sửa Thông Tin Sinh Viên</title>
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
        <h2>Sửa Thông Tin Sinh Viên</h2>
        <form method="POST" action="sua_sv.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="maSV">Mã Sinh Viên</label>
                <input type="text" class="form-control" id="maSV" name="maSV" value="<?php echo $maSV; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="hoLot">Họ Lót</label>
                <input type="text" class="form-control" id="hoLot" name="hoLot" value="<?php echo $hoLot; ?>" required>
            </div>
            <div class="form-group">
                <label for="tenSV">Tên Sinh Viên</label>
                <input type="text" class="form-control" id="tenSV" name="tenSV" value="<?php echo $tenSV; ?>" required>
            </div>
            <div class="form-group">
                <label for="ngaySinh">Ngày Sinh</label>
                <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" value="<?php echo $ngaySinh; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="gioiTinh">Giới Tính</label>
                <select class="form-control" id="gioiTinh" name="gioiTinh" required>
                    <option value="Nam" <?php if ($gioiTinh == 'Nam')
                        echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if ($gioiTinh == 'Nữ')
                        echo 'selected'; ?>>Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="maLop">Mã Lớp</label>
                <select class="form-control" id="maLop" name="maLop" required>
                    <?php
                    // Hiển thị tất cả các lớp học trong dropdown
                    if ($result_all_lop->num_rows > 0) {
                        while ($row_all_lop = $result_all_lop->fetch_assoc()) {
                            $selected = ($row_all_lop['maLop'] == $maLop) ? 'selected' : '';
                            echo "<option value='" . $row_all_lop['maLop'] . "' $selected>" . $row_all_lop['maLop'] . " - " . $row_all_lop['tenLop'] . "</option>";
                        }
                    }

                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="Streetname">Tên đường, Số nhà:</label>
                <input type="text" id="Streetname" name="txtStreetname" class="form-control"
                    placeholder="Tên đường, Số nhà" value="<?php echo htmlspecialchars($streetname); ?>" required>
            </div>

            <div class="form-group">
                <label for="province">Tỉnh/Thành Phố:</label>
                <select id="province" name="txtProvince" class="form-control" required>
                    <option value="">Chọn tỉnh/thành phố</option>
                    <!-- Options will be populated by address.js -->
                </select>
            </div>

            <div class="form-group">
                <label for="district">Quận/Huyện:</label>
                <select id="district" name="txtDistrict" class="form-control" required>
                    <option value="">Chọn quận/huyện</option>
                    <!-- Options will be populated by address.js -->
                </select>
            </div>

            <div class="form-group">
                <label for="ward">Xã/Phường:</label>
                <select id="ward" name="txtWard" class="form-control" required>
                    <option value="">Chọn xã/phường</option>
                    <!-- Options will be populated by address.js -->
                </select>
            </div>
            <!--lưu full địa chỉ -->
            <input type="hidden" id="fullAddress" name="txtFullAddress">

            <div class="form-group">
                <label for="fileToUpload">Chọn ảnh mới (nếu có):</label>
                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
            </div>



            <button type="submit" class="btn btn-primary">
                <i class="fa fa-sync"></i> Cập Nhật
            </button>
        </form>
    </div>
    <!-- Include Axios library -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Include your custom JavaScript file -->
    <script src="address.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Đặt giá trị mặc định cho Streetname
            document.getElementById('Streetname').value = "<?php echo addslashes($streetname); ?>";

            // Đặt giá trị mặc định cho Province và trigger sự kiện change
            var provinceSelect = document.getElementById('province');
            var defaultProvince = "<?php echo addslashes($province); ?>";

            // Hàm này sẽ chạy sau khi danh sách tỉnh/thành phố được tải
            var setDefaultProvince = function () {
                for (var i = 0; i < provinceSelect.options.length; i++) {
                    if (provinceSelect.options[i].text === defaultProvince) {
                        provinceSelect.selectedIndex = i;
                        // Trigger sự kiện change để load quận/huyện
                        var event = new Event('change');
                        provinceSelect.dispatchEvent(event);
                        break;
                    }
                }
            };

            // Nếu danh sách tỉnh/thành phố đã được tải, set giá trị mặc định ngay lập tức
            if (provinceSelect.options.length > 1) {
                setDefaultProvince();
            } else {
                // Nếu chưa, đợi 1 giây rồi thử lại
                setTimeout(setDefaultProvince, 1000);
            }

            // Đặt giá trị mặc định cho District và Ward
            var districtSelect = document.getElementById('district');
            var wardSelect = document.getElementById('ward');
            var defaultDistrict = "<?php echo addslashes($district); ?>";
            var defaultWard = "<?php echo addslashes($ward); ?>";

            // Hàm này sẽ chạy sau khi danh sách quận/huyện được tải
            var setDefaultDistrict = function () {
                for (var i = 0; i < districtSelect.options.length; i++) {
                    if (districtSelect.options[i].text === defaultDistrict) {
                        districtSelect.selectedIndex = i;
                        // Trigger sự kiện change để load phường/xã
                        var event = new Event('change');
                        districtSelect.dispatchEvent(event);
                        break;
                    }
                }
            };

            // Hàm này sẽ chạy sau khi danh sách phường/xã được tải
            var setDefaultWard = function () {
                for (var i = 0; i < wardSelect.options.length; i++) {
                    if (wardSelect.options[i].text === defaultWard) {
                        wardSelect.selectedIndex = i;
                        break;
                    }
                }
            };

            // Đợi quận/huyện được tải xong rồi set giá trị mặc định
            provinceSelect.addEventListener('change', function () {
                setTimeout(setDefaultDistrict, 1000);
            });

            // Đợi phường/xã được tải xong rồi set giá trị mặc định
            districtSelect.addEventListener('change', function () {
                setTimeout(setDefaultWard, 1000);
            });
        });
    </script>
</body>

</html>