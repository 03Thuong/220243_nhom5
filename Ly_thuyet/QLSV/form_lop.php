<!DOCTYPE html>
<html lang="en">
<head>
  <title>Form LỚP HỌC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #FFEFD5
    }

    .container {
      margin-top: 50px;
      background-color: #fff; 
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 600px; /*Độ rộng form */
    }

    h2 {
      color: #007bff;
      text-align: center;
      margin-bottom: 30px;
    }

    label {
      font-size: 18px; /* Increase the font size of labels */
      font-weight: bold;
    }

    .form-control {
      border-radius: 5px;
      border: 1px solid #ced4da;
    }

    .btn-primary {
  	  width: 150px; /* Điều chỉnh chiều rộng phù hợp */
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
  <h2>QUẢN LÝ THÔNG TIN LỚP HỌC</h2>
  <form action="xuly_themlop.php" method="post">
    <div class="form-group">
      <label for="malop">Mã lớp:</label>
      <input type="text" class="form-control" id="malop" placeholder="Nhập mã lớp" name="txtMa" required>
    </div>
    <div class="form-group">
      <label for="tenlop">Tên lớp:</label>
      <input type="text" class="form-control" id="tenlop" placeholder="Nhập tên lớp" name="txtTen"required>
    </div>

  
    <div class="text-center">
      <button type="submit" class="btn btn-primary">
        <i class="fa fa-plus"></i> Thêm mới
      </button>
      <a class="btn btn-primary" href="lophoc.php" style="margin-left: 20px;">
        <i class="fa fa-undo"></i> Quay lại
      </a>
</div>

    </div>
  </form>
</div>

</body>
</html>
