<?php
session_start(); // Bắt đầu phiên
include('include/config.php'); // Bao gồm file cấu hình
if(strlen($_SESSION['alogin'])==0) { // Kiểm tra xem người dùng đã đăng nhập hay chưa
    header('location:index.php'); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
} else {
    $pid = intval($_GET['id']); // Lấy ID sản phẩm
    if(isset($_POST['submit'])) { // Kiểm tra xem có nhấn nút gửi không
        $productname = $_POST['productName']; // Lấy tên sản phẩm
        $productimage1 = $_FILES["productimage1"]["name"]; // Lấy tên hình ảnh sản phẩm

        // Di chuyển hình ảnh được tải lên vào thư mục
        move_uploaded_file($_FILES["productimage1"]["tmp_name"], "productimages/$pid/".$_FILES["productimage1"]["name"]);
        // Cập nhật hình ảnh sản phẩm trong cơ sở dữ liệu
        $sql = mysqli_query($con, "UPDATE products SET productImage1='$productimage1' WHERE id='$pid' ");
        $_SESSION['msg'] = "Cập nhật hình ảnh sản phẩm thành công !!"; // Thông báo thành công
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị | Cập nhật hình ảnh sản phẩm</title> <!-- Tiêu đề trang -->
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap -->
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"> <!-- Liên kết đến CSS Bootstrap đáp ứng -->
    <link type="text/css" href="css/theme.css" rel="stylesheet"> <!-- Liên kết đến CSS chủ đề -->
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet"> <!-- Liên kết đến CSS Font Awesome -->
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'> <!-- Liên kết đến font -->
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script> <!-- Khởi tạo NicEdit cho các textarea -->

    <script>
    function getSubcat(val) { // Hàm lấy danh mục con
        $.ajax({
            type: "POST",
            url: "get_subcat.php",
            data: 'cat_id=' + val,
            success: function(data) {
                $("#subcategory").html(data); // Hiển thị danh mục con
            }
        });
    }
    function selectCountry(val) { // Hàm chọn quốc gia
        $("#search-box").val(val);
        $("#suggesstion-box").hide(); // Ẩn hộp gợi ý
    }
    </script>
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
                            <h3>Cập nhật hình ảnh sản phẩm 1</h3> <!-- Tiêu đề chính -->
                        </div>
                        <div class="module-body">

                            <?php if(isset($_POST['submit'])) { ?> <!-- Kiểm tra nếu có thông báo thành công -->
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Thành công!</strong> <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                                </div>
                            <?php } ?>

                            <br />

                            <form class="form-horizontal row-fluid" name="insertproduct" method="post" enctype="multipart/form-data"> <!-- Form cập nhật sản phẩm -->

<?php 
$query = mysqli_query($con, "SELECT productName, productImage1 FROM products WHERE id='$pid'"); // Lấy tên sản phẩm và hình ảnh hiện tại
$cnt = 1;
while($row = mysqli_fetch_array($query)) { // Duyệt qua từng sản phẩm
?>

<div class="control-group">
    <label class="control-label" for="basicinput">Tên sản phẩm</label>
    <div class="controls">
        <input type="text" name="productName" readonly value="<?php echo htmlentities($row['productName']);?>" class="span8 tip" required> <!-- Hiển thị tên sản phẩm -->
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="basicinput">Hình ảnh sản phẩm hiện tại</label>
    <div class="controls">
        <img src="productimages/<?php echo htmlentities($pid);?>/<?php echo htmlentities($row['productImage1']);?>" width="200" height="100"> <!-- Hiển thị hình ảnh sản phẩm hiện tại -->
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="basicinput">Hình ảnh sản phẩm mới</label>
    <div class="controls">
        <input type="file" name="productimage1" id="productimage1" class="span8 tip" required> <!-- Trường tải lên hình ảnh sản phẩm mới -->
    </div>
</div>

<?php } ?>

    <div class="control-group">
        <div class="controls">
            <button type="submit" name="submit" class="btn">Cập nhật</button> <!-- Nút gửi -->
        </div>
    </div>
</form>
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
