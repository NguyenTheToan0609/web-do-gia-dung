<?php 
session_start(); // Bắt đầu phiên
include_once('includes/config.php'); // Bao gồm file cấu hình
if(strlen($_SESSION["aid"])==0) {   
    header('location:logout.php'); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng xuất
} else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" /> <!-- Đặt charset là utf-8 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Hỗ trợ IE -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> <!-- Responsive thiết kế -->
        <meta name="description" content="" /> <!-- Mô tả trang -->
        <meta name="author" content="" /> <!-- Tác giả trang -->
        <title>Portal Mua Sắm | Đơn hàng của Người dùng</title> <!-- Tiêu đề trang -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" /> <!-- Liên kết đến CSS DataTables -->
        <link href="css/styles.css" rel="stylesheet" /> <!-- Liên kết đến CSS cho trang -->
        <script src="js/all.min.js" crossorigin="anonymous"></script> <!-- Liên kết đến JS cho biểu tượng -->
    </head>
    <body class="sb-nav-fixed">
        <?php include_once('includes/header.php');?> <!-- Bao gồm phần đầu trang -->
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php');?> <!-- Bao gồm thanh bên -->
            <div id="layoutSidenav_content">
                <main>
                    <?php 
                    $userid = $_GET['uid']; // Lấy ID người dùng từ tham số URL
                    $username = $_GET['uname']; // Lấy tên người dùng từ tham số URL
                    ?>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Quản lý Đơn hàng của <?php echo $username;?> </h1> <!-- Tiêu đề chính -->
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Bảng điều khiển</a></li> <!-- Liên kết đến bảng điều khiển -->
                            <li class="breadcrumb-item active">Quản lý Đơn hàng của <?php echo $username;?> </li> <!-- Tiêu đề phụ -->
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i> <!-- Biểu tượng bảng -->
                                Tất cả Chi tiết Đơn hàng <!-- Tiêu đề bảng -->
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th> <!-- Thứ tự -->
                                            <th>Đơn hàng số.</th> <!-- Số đơn hàng -->
                                            <th>Người đặt hàng</th> <!-- Người đặt hàng -->
                                            <th>Số tiền đơn hàng</th> <!-- Số tiền đơn hàng -->
                                            <th>Ngày đặt hàng</th> <!-- Ngày đặt hàng -->
                                            <th>Trạng thái đơn hàng</th> <!-- Trạng thái đơn hàng -->
                                            <th>Hành động</th> <!-- Hành động -->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Đơn hàng số.</th>
                                            <th>Người đặt hàng</th>
                                            <th>Số tiền đơn hàng</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Trạng thái đơn hàng</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php 
$query = mysqli_query($con, "SELECT orders.id, orderNumber, totalAmount, orderStatus, orderDate, users.name, users.contactno 
    FROM `orders` JOIN users ON users.id=orders.userId WHERE orders.userId='$userid'"); // Truy vấn để lấy thông tin đơn hàng
$cnt = 1; // Biến đếm
$count = mysqli_num_rows($query); // Đếm số lượng kết quả
if($count > 0) { // Nếu có đơn hàng
    while($row = mysqli_fetch_array($query)) { // Duyệt qua từng hàng dữ liệu
?>  
                                <tr>
                                            <td><?php echo htmlentities($cnt);?></td> <!-- Hiển thị thứ tự -->
                                            <td><?php echo htmlentities($row['orderNumber']);?></td> <!-- Hiển thị số đơn hàng -->
                                            <td><?php echo htmlentities($row['name']);?></td> <!-- Hiển thị tên người đặt hàng -->
                                            <td><?php echo htmlentities($row['totalAmount']);?></td> <!-- Hiển thị số tiền đơn hàng -->
                                            <td><?php echo htmlentities($row['orderDate']);?></td> <!-- Hiển thị ngày đặt hàng -->
                                            <td><?php echo htmlentities($row['orderStatus']);?></td> <!-- Hiển thị trạng thái đơn hàng -->
                                            <td>
                                                <a href="order-details.php?orderid=<?php echo $row['id']?>" target="_blank">
                                                    <i class="fas fa-file fa-2x" title="Xem Chi tiết Đơn hàng"></i></a> <!-- Liên kết đến chi tiết đơn hàng -->
                                            </td>
                                        </tr>
                                        <?php 
                                        $cnt = $cnt + 1; // Tăng biến đếm lên 1
    } 
} else { // Nếu không có đơn hàng
?>  
                                   <tr>
                                       <th colspan="7" style="color:red;">Không tìm thấy đơn hàng</th> <!-- Hiển thị thông báo không có đơn hàng -->
                                   </tr>
<?php } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once('includes/footer.php');?> <!-- Bao gồm phần chân trang -->
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> <!-- Liên kết đến JS Bootstrap -->
        <script src="js/scripts.js"></script> <!-- Liên kết đến JS trang -->
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script> <!-- Liên kết đến JS DataTables -->
        <script src="js/datatables-simple-demo.js"></script> <!-- Liên kết đến JS để khởi tạo DataTables -->
    </body>
</html>
<?php } ?>
