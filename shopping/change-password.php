<?php session_start();
include_once('includes/config.php');
if(strlen($_SESSION['id'])==0)
{   header('location:logout.php');
}else{

//For changing  User  Profile Password
if(isset($_POST['update']))
{
$currentpwd=md5($_POST['cpass']);
$newpwd=md5($_POST['newpass']);
$uid=$_SESSION['id'];
$sql=mysqli_query($con,"SELECT id FROM  users where password='$currentpwd' and id='$uid'");
$num=mysqli_num_rows($sql);
if($num>0)
{
 $con=mysqli_query($con,"update users set password='$newpwd' where id='$uid'");
 echo "<script>alert('Thay đổi mật khẩu thành công!');</script>"; 
 echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
}else{
    echo "<script>alert('Mật khẩu hiện tại không khớp!');</script>";
     echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Mua sắm | Đăng ký người dùng</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
       <!--  <link href="css/bootstrap.min.css" rel="stylesheet" /> -->
       <script type="text/javascript">
function valid()
{
if(document.chngpwd.cpass.value=="")
{
    alert("Trường Mật khẩu hiện tại trống!");
document.chngpwd.cpass.focus();
return false;
}
else if(document.chngpwd.newpass.value=="")
{
    alert("Trường Mật khẩu mới trống!");
document.chngpwd.newpass.focus();
return false;
}
else if(document.chngpwd.cnfpass.value=="")
{
    alert("Trường Xác nhận mật khẩu trống!");
document.chngpwd.cnfpass.focus();
return false;
}
else if(document.chngpwd.newpass.value!= document.chngpwd.cnfpass.value)
{
    alert("Mật khẩu và Xác nhận mật khẩu không khớp!");
document.chngpwd.cnfpass.focus();
return false;
}
return true;
}
</script>
    </head>
<style type="text/css"></style>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Thay đổi mật khẩu</h1>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     
<form method="post" name="chngpwd" onSubmit="return valid();">
     <div class="row">
     <div class="col-2">Mật khẩu hiện tại</div>
         <div class="col-6">    
            <input type="password" class="form-control" id="cpass" name="cpass" required="required"></div>
     </div>
       <div class="row mt-3">
         <div class="col-2">Mật khẩu mới</div>
         <div class="col-6">
     <input type="password" class="form-control" id="newpass" name="newpass">
         </div>
          
     </div>

       <div class="row mt-3">
       <div class="col-2">Mật khẩu hiện tại</div>
         <div class="col-6"><input type="password" class="form-control" id="cnfpass" name="cnfpass" required="required" ></div>
     </div>



               <div class="row mt-3">
                 <div class="col-4">&nbsp;</div>
         <div class="col-6"><input type="submit" name="update" id="update" class="btn btn-primary" value="Update" required></div>
     </div>
 </form>
              
            </div>
 
</div>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>
