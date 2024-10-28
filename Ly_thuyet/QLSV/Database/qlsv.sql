-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 27, 2024 lúc 12:30 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlsv`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `image`
--

CREATE TABLE `image` (
  `id_image` int(11) NOT NULL,
  `maSV` varchar(9) DEFAULT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `image`
--

INSERT INTO `image` (`id_image`, `maSV`, `url`) VALUES
(1, '676767676', 'uploads/Module 1. Challenge The basics of user experience design.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lophoc`
--

CREATE TABLE `lophoc` (
  `maLop` varchar(9) NOT NULL,
  `tenLop` varchar(100) DEFAULT NULL,
  `ghiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lophoc`
--

INSERT INTO `lophoc` (`maLop`, `tenLop`, `ghiChu`) VALUES
('DA21TTC', 'Đại học Công nghệ thông tin C khóa 21', ''),
('DA23CK', 'Đại học CNKT Cơ khí khóa 2023', ''),
('DA23TTD', 'Đại học Công nghệ thông tin D khóa 23', ''),
('DF23TT', 'Đại học Liên thông CNTT khóa 23', ''),
('VB23TT', 'Văn bằng 2 - Công nghệ thông tin khóa 21', 'Văn bằng 2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sinhvien`
--

CREATE TABLE `sinhvien` (
  `maSV` varchar(9) NOT NULL,
  `hoLot` varchar(20) NOT NULL,
  `tenSV` varchar(10) NOT NULL,
  `gioiTinh` varchar(6) DEFAULT NULL,
  `ngaySinh` date NOT NULL,
  `maLop` varchar(9) DEFAULT NULL,
  `diaChi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sinhvien`
--

INSERT INTO `sinhvien` (`maSV`, `hoLot`, `tenSV`, `gioiTinh`, `ngaySinh`, `maLop`, `diaChi`) VALUES
('110121169', 'Nguyễn Thị', 'Mỹ Trân', 'Nam', '2003-07-01', 'DA21TTC', 'Số 77777, Huyện Trà Ôn, Tỉnh Vĩnh Long'),
('110121180', 'Phạm', 'Hoài Nam', 'Nam', '2000-12-23', 'DA21TTC', 'Điện Biên Phủ, Thành phố Trà Vinh, Tỉnh Trà Vinh'),
('110121200', 'Trần Văn', 'Nam', 'Nam', '2005-09-20', 'DA23CK', 'Hẻm 220, Phường 6, Thành phố Trà Vinh, Tỉnh Trà Vinh'),
('110121223', 'Ngô Thanh', 'Quyền', 'Nam', '2003-04-01', 'DF23TT', 'hẻm 51, Phường 5, Thành phố Trà Vinh, Tỉnh Trà Vinh'),
('110121225', 'Nguyễn Văn', 'A', 'Nam', '2003-01-01', 'DA23TTD', 'Hẻm 220, Phường 6, Thành phố Trà Vinh, Tỉnh Trà Vinh'),
('110121249', 'Nguyễn Khánh', 'Băng', 'Nữ', '2005-08-18', 'DA23CK', 'Đường Đồng Khởi, Phường 9, Thành phố Trà Vinh, Tỉnh Trà Vinh'),
('110121290', 'Lê Thị', 'Loan', 'Nữ', '2005-07-12', 'DA23CK', 'Điện Biên Phủ, Phường 2, Thành phố Trà Vinh, Tỉnh Trà Vinh'),
('110145234', 'Phan', 'Thanh Sơn', 'Nam', '2005-03-04', 'DA23CK', 'Đường Kiên Thị Nhẫn, Phường 7, Thành phố Trà Vinh, Tỉnh Trà Vinh'),
('110211211', 'Trần Thị', 'Thùy Dương', 'Nam', '2003-02-01', 'DA21TTC', 'Hẻm 220, Huyện Vũng Liêm, Tỉnh Vĩnh Long'),
('110898989', 'Trần', 'Hoàng', 'Nam', '2000-12-13', 'DA23CK', 'Hẻm 220, Xã Long Toàn, Thị xã Duyên Hải, Tỉnh Trà Vinh'),
('11111111', 'Trần Văn', 'Nam', 'Nam', '2005-09-03', 'DF23TT', 'số 123, Phường Hàng Trống, Quận Hoàn Kiếm, Thành phố Hà Nội'),
('11115555', 'Nguyễn Thị', 'Thanh', 'Nữ', '1985-08-24', 'DF23TT', 'Số 203, Phường Mỹ Xuyên, Thành phố Long Xuyên, Tỉnh An Giang'),
('555555555', 'Nguyễn Quốc', 'A', 'Nam', '2005-10-10', 'DA23TTD', 'Đường Lý Tự Trọng, Phường 8, Quận Gò Vấp, Thành phố Hồ Chí Minh'),
('676767676', 'Nguyễn Quốc', 'Nam', 'Nam', '2003-10-15', 'DA21TTC', 'Đường Võ Nguyên Giáp, Xã Nhơn Mỹ, Huyện Kế Sách, Tỉnh Sóc Trăng'),
('78787888', 'Trần Văn', 'Nam', 'Nam', '2003-06-06', 'DA21TTC', 'Võ Thị Sáu, Phường Tân An, Quận Ninh Kiều, Thành phố Cần Thơ'),
('820121019', 'Trần Tuấn', 'Hải', 'Nam', '1994-08-26', 'VB23TT', 'Số 178, Xã Tân Lập, Huyện Tân Thạnh, Tỉnh Long An'),
('820121042', 'Bùi Duy', 'Khang', 'Nam', '1996-11-23', 'VB23TT', 'số 789, Phường 16, Quận 8, Thành phố Hồ Chí Minh'),
('999999999', 'Trần Văn', 'A', 'Nam', '2005-11-01', 'VB23TT', 'Đường Kiên Thị Nhẫn, Phường 9, Thành phố Trà Vinh, Tỉnh Trà Vinh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(2, 'admin', '123', 'admin', NULL),
(3, 'abc', '123', 'user', NULL),
(5, 'quyen', '456', 'user', NULL),
(11, 'Hoàng thương Nguyễn', '$2y$10$Umie3GgqhgYKQa9tJAYNbupn1LRw87vBh2abOiKrVq1fXYbFe1YkK', 'user', 'nguyenhoangthuong825@gmail.com'),
(12, 'Hoàng Thương Nguyễn', '$2y$10$xxvZHr0DJ9eQzo6Rn.5w5OWypkRWRXN4Judcy0pJlEtssT1N0aXIq', 'user', 'hoangthuongn579@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `maSV` (`maSV`);

--
-- Chỉ mục cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  ADD PRIMARY KEY (`maLop`);

--
-- Chỉ mục cho bảng `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`maSV`),
  ADD KEY `maLop` (`maLop`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `image`
--
ALTER TABLE `image`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`maSV`) REFERENCES `sinhvien` (`maSV`);

--
-- Các ràng buộc cho bảng `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD CONSTRAINT `sinhvien_ibfk_1` FOREIGN KEY (`maLop`) REFERENCES `lophoc` (`maLop`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
