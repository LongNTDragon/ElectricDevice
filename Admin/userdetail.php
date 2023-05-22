<?php
    require "../Class/Database.php";
    require "autoload.php";
    session_start();

    if(!isset($_SESSION['user']))
    {
        echo "<script>alert('Bạn chưa đăng nhập.');
        window.location.href='../login.php'</script>";
    }
    else
    {
        if($_SESSION['user'][0]->roleID != "1")
        {
            echo "<script>alert('Bạn không có quyền vào trang này.');
            window.location.href='../index.php'</script>";
        }
    }

    $con = Database::connectDB();
    $u = new User();

    if(!isset($_GET['userID']))
        header("location:bill.php");
        
    $u->userID = $_GET['userID'];

    $data = $u->getAUserByID($con);

    if(empty($data))
        header("location:bill.php");
?>

<?php require "./Layout/header.php"?>
<title>User Information</title>
<?php require "../CSS/register_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card bg-white">
          <div class="card-body">
            <h2 class="text-center">THÔNG TIN NGƯỜI DÙNG</h2>
            
            <form action="" method="post">                
                <div class="row m-1 mt-3">
                    <div class="col-md-6">
                        <label for="username">Họ và tên</label>
                        <input readonly class="form-control" name="fullname" type="text" value="<?= $data[0]->fullname?>"/>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="phone">Số điện thoại</label>
                        <input readonly class="form-control" name="phone" type="text" value="<?= $data[0]->phone?>"/>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <label for="email">Email</label>
                        <input readonly class="form-control" name="email" type="email" value="<?= $data[0]->email?>"/>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <label for="address">Địa chỉ</label>
                        <input readonly class="form-control" name="address" type="text" value="<?= $data[0]->address?>"/>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>