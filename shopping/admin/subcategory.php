<?php
session_start(); // Bắt đầu phiên
include('include/config.php'); // Bao gồm file cấu hình
if(strlen($_SESSION['alogin'])==0) { // Kiểm tra xem người dùng đã đăng nhập hay chưa
    header('location:index.php'); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
} else {
    if(isset($_POST['submit'])) { // Kiểm tra nếu có gửi form
        $category = $_POST['category']; // Lấy dữ liệu danh mục
        $subcat = $_POST['subcategory']; // Lấy dữ liệu danh mục con
        $sql = mysqli_query($con, "INSERT INTO subcategory(categoryid, subcategory) VALUES('$category', '$subcat')"); // Thêm danh mục con vào cơ sở dữ liệu
        $_SESSION['msg'] = "Danh mục con đã được tạo !!"; // Thông báo thành công
    }

    if(isset($_GET['del'])) { // Kiểm tra nếu có yêu cầu xóa
        mysqli_query($con, "DELETE FROM subcategory WHERE id = '".$_GET['id']."'"); // Xóa danh mục con khỏi cơ sở dữ liệu
        $_SESSION['delmsg'] = "Danh mục con đã được xóa !!"; // Thông báo xóa thành công
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị | Danh mục con</title> <!-- Tiêu đề trang -->
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap -->
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap đáp ứng -->
    <link type="text/css" href="css/theme.css" rel="stylesheet"> <!-- Liên kết đến CSS chủ đề -->
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet"> <!-- Liên kết đến CSS Font Awesome -->
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'> <!-- Liên kết đến font -->
</head>
<body>
<?php include('include/header.php');?> <!-- Bao gồm phần đầu trang -->

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php');?> <!-- Bao gồm thanh bên -->
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Danh mục con</h3> <!-- Tiêu đề chính -->
                        </div>
                        <div class="module-body">

                            <?php if(isset($_POST['submit'])) { ?>
                                <div class="alert alert-success"> <!-- Thông báo thành công -->
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Tốt lắm!</strong> <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                                </div>
                            <?php } ?>

                            <?php if(isset($_GET['del'])) { ?>
                                <div class="alert alert-error"> <!-- Thông báo lỗi -->
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Ôi không!</strong> <?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
                                </div>
                            <?php } ?>

                            <br />

                            <form class="form-horizontal row-fluid" name="subcategory" method="post"> <!-- Form để tạo danh mục con -->

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Danh mục</label>
                                    <div class="controls">
                                        <select name="category" class="span8 tip" required>
                                            <option value="">Chọn danh mục</option> 
                                            <?php 
                                            $query = mysqli_query($con, "SELECT * FROM category"); // Lấy danh sách danh mục
                                            while($row = mysqli_fetch_array($query)) { ?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['categoryName'];?></option> <!-- Hiển thị danh sách danh mục -->
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Tên danh mục con</label>
                                    <div class="controls">
                                        <input type="text" placeholder="Nhập tên danh mục con" name="subcategory" class="span8 tip" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" name="submit" class="btn btn-primary">Tạo</button> <!-- Nút gửi -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="module">
                        <div class="module-head">
                            <h3>Danh mục con</h3> <!-- Tiêu đề phụ -->
                        </div>
                        <div class="module-body table">
                            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Danh mục</th>
                                        <th>Mô tả</th>
                                        <th>Ngày tạo</th>
                                        <th>Cập nhật cuối</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php 
$query = mysqli_query($con, "SELECT subcategory.id, category.categoryName, subcategory.subcategory, subcategory.creationDate, subcategory.updationDate FROM subcategory JOIN category ON category.id = subcategory.categoryid"); // Lấy danh sách danh mục con
$cnt = 1;
while($row = mysqli_fetch_array($query)) { ?>
    <tr>
        <td><?php echo htmlentities($cnt);?></td> <!-- Số thứ tự -->
        <td><?php echo htmlentities($row['categoryName']);?></td> <!-- Tên danh mục -->
        <td><?php echo htmlentities($row['subcategory']);?></td> <!-- Tên danh mục con -->
        <td><?php echo htmlentities($row['creationDate']);?></td> <!-- Ngày tạo -->
        <td><?php echo htmlentities($row['updationDate']);?></td> <!-- Ngày cập nhật -->
        <td>
            <a href="edit-subcategory.php?id=<?php echo $row['id']?>"><i class="icon-edit"></i></a> <!-- Liên kết đến trang chỉnh sửa danh mục con -->
            <a href="subcategory.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Bạn có chắc chắn muốn xóa không?')"><i class="icon-remove-sign"></i></a> <!-- Liên kết xóa danh mục con -->
        </td>
    </tr>
    <?php $cnt = $cnt + 1; } ?>
</tbody>
                            </table>
                        </div>
                    </div>						

                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php');?> <!-- Bao gồm phần chân trang -->

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script> <!-- Liên kết đến JS jQuery -->
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script> <!-- Liên kết đến JS jQuery UI -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script> <!-- Liên kết đến JS Bootstrap -->
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script> <!-- Liên kết đến JS Flot -->
<script src="scripts/datatables/jquery.dataTables.js"></script> <!-- Liên kết đến JS DataTables -->
<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable(); // Khởi tạo DataTable
        $('.dataTables_paginate').addClass("btn-group datatable-pagination"); // Thêm lớp cho phân trang
        $('.dataTables_paginate > a').wrapInner('<span />'); // Bọc nội dung phân trang
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>'); // Thêm biểu tượng mũi tên trái
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>'); // Thêm biểu tượng mũi tên phải
    });
</script>
</body>
<?php } ?>
