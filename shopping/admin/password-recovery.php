<?php
session_start(); // Bắt đầu phiên
//error_reporting(0); // Tắt báo lỗi
include("includes/config.php"); // Bao gồm file cấu hình
if (isset($_POST['submit'])) { // Kiểm tra xem nút submit có được nhấn không
    $username = $_POST['username']; // Lấy tên người dùng từ form
    $cnumber = $_POST['contactno']; // Lấy số điện thoại từ form
    $newpassword = md5($_POST['inputPassword']); // Mã hóa mật khẩu mới
    $ret = mysqli_query($con, "SELECT id FROM tbladmin WHERE username='$username' and contactNumber='$cnumber'"); // Truy vấn để tìm người dùng
    $num = mysqli_num_rows($ret); // Đếm số hàng kết quả
    if ($num > 0) { // Nếu tìm thấy người dùng
        $query = mysqli_query($con, "UPDATE tbladmin SET password='$newpassword' WHERE username='$username' and contactNumber='$cnumber'"); // Cập nhật mật khẩu

        echo "<script>alert('Mật khẩu đã được đặt lại thành công.');</script>"; // Hiển thị thông báo thành công
        echo "<script type='text/javascript'> document.location ='index.php'; </script>"; // Chuyển hướng về trang đăng nhập
    } else {
        echo "<script>alert('Tên người dùng hoặc số điện thoại không hợp lệ');</script>"; // Thông báo lỗi nếu không tìm thấy
        echo "<script type='text/javascript'> document.location ='password-recovery.php'; </script>"; // Chuyển hướng về trang khôi phục mật khẩu
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Cổng Mua Sắm | Khôi phục Mật Khẩu </title> <!-- Tiêu đề trang -->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript">
            function valid() { // Hàm kiểm tra tính hợp lệ
                if (document.passwordrecovery.inputPassword.value != document.passwordrecovery.cinputPassword.value) { // So sánh mật khẩu và xác nhận
                    alert("Mật khẩu và Mật khẩu xác nhận không khớp !!"); // Thông báo lỗi
                    document.passwordrecovery.cinputPassword.focus(); // Đưa con trỏ về ô xác nhận mật khẩu
                    return false;
                }
                return true; // Trả về true nếu mật khẩu hợp lệ
            }
        </script>
    </head>
    <body class="bg-primary"> <!-- Nền màu xanh -->
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5"> <!-- Card hiển thị -->
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Cổng Mua Sắm | Khôi phục Mật Khẩu</h3></div>
                                    <div class="card-body">
                                        <form method="post" name="passwordrecovery" onSubmit="return valid();"> <!-- Form khôi phục mật khẩu -->
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="username" name="username" type="text" placeholder="Tên người dùng" required />
                                                <label for="username">Tên người dùng</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="contactno" name="contactno" type="text" placeholder="Số điện thoại" required />
                                                <label for="username">Số điện thoại</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Mật khẩu" required />
                                                <label for="inputPassword">Mật khẩu mới</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="cinputPassword" name="cinputPassword" type="password" placeholder="Xác nhận mật khẩu" required />
                                                <label for="inputPassword">Xác nhận mật khẩu</label>
                                            </div>
                                        
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password-recovery.php">Quên mật khẩu?</a>
                                                <button type="submit" name="submit" class="btn btn-primary">Gửi</button> <!-- Nút gửi -->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="../index.php">Quay lại Trang Chủ</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <?php include_once('includes/footer.php'); ?> <!-- Bao gồm footer -->
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
