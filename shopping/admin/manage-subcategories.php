<?php
session_start(); // Bắt đầu phiên
include_once('includes/config.php'); // Bao gồm file cấu hình
error_reporting(0); // Tắt báo cáo lỗi
if(strlen($_SESSION["aid"])==0) // Kiểm tra xem phiên đã được thiết lập chưa
{   
header('location:logout.php'); // Chuyển hướng đến trang đăng xuất nếu không
} else {

if(isset($_GET['del'])) // Nếu có yêu cầu xóa
{
mysqli_query($con,"delete from subcategory where id = '".$_GET['id']."'"); // Thực hiện truy vấn xóa danh mục phụ
echo "<script>alert('Dữ liệu đã bị xóa');</script>"; // Hiển thị thông báo
echo "<script>window.location.href='manage-subcategories.php'</script>"; // Chuyển hướng đến trang quản lý danh mục phụ
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
        <title>Chợ điện tử | Quản lý danh mục phụ</title> <!-- Tiêu đề trang -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
 <?php include_once('includes/header.php'); ?> <!-- Bao gồm header -->
        <div id="layoutSidenav">
       <?php include_once('includes/sidebar.php'); ?> <!-- Bao gồm sidebar -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Quản lý danh mục phụ</h1> <!-- Tiêu đề -->
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item active">Quản lý danh mục phụ</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               Chi tiết danh mục phụ
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Danh mục phụ</th>
                                            <th>Danh mục</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Người tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>#</th>
                                            <th>Danh mục phụ</th>                                           
                                            <th>Danh mục</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Người tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php 
$query=mysqli_query($con,"select category.categoryName,subcategory.subcategoryName as subcatname,subcategory.creationDate,subcategory.updationDate,subcategory.id as subid,tbladmin.username from subcategory join category on subcategory.categoryid=category.id join tbladmin on tbladmin.id=subcategory.createdBy"); // Truy vấn để lấy danh mục phụ
$cnt=1; // Khởi tạo biến đếm
while($row=mysqli_fetch_array($query)) // Duyệt qua từng dòng kết quả
{
?>  
                                <tr>
                                            <td><?php echo htmlentities($cnt); ?></td> <!-- Số thứ tự -->
                                            <td><?php echo htmlentities($row['subcategoryName']); ?></td> <!-- Tên danh mục phụ -->
                                            <td><?php echo htmlentities($row['categoryName']); ?></td> <!-- Tên danh mục -->
                                            <td><?php echo htmlentities($row['creationDate']); ?></td> <!-- Ngày tạo -->
                                            <td><?php echo htmlentities($row['updationDate']); ?></td> <!-- Ngày cập nhật -->
                                            <td><?php echo htmlentities($row['username']); ?></td> <!-- Người tạo -->
                                            <td>
                                            <a href="edit-subcategory.php?id=<?php echo $row['subid']?>"><i class="fas fa-edit"></i></a> | 
                                            <a href="manage-subcategories.php?id=<?php echo $row['subid']?>&del=delete" onClick="return confirm('Bạn có chắc chắn muốn xóa không?')"><i class="fa fa-trash" aria-hidden="true"></i></a> <!-- Liên kết xóa -->
                                            </td>
                                        </tr>
                                        <?php $cnt=$cnt+1; } ?> <!-- Tăng biến đếm -->
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
<?php include_once('includes/footer.php'); ?> <!-- Bao gồm footer -->
                </footer>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>
