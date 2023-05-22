<?php
    require "config.php";
    require "autoload.php";
    session_start();

    if(!isset($_SESSION['user']))
    {
        echo "<script>alert('Bạn chưa đăng nhập.');
        window.location.href='login.php'</script>";
    }

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $u = new User();

    $u->userID = $_SESSION['user'][0]->userID;
    $data = $u->getAUserByID($con);
?>

<?php
    $user = $data[0]->username; 
    $phone = $data[0]->phone;
    $email = $data[0]->email; 
    $oldEmail = $data[0]->email;
    $address = $data[0]->address;

    if(isset($_POST['submit']))
    {
        $user = $_POST['username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $u = new User();
        $u->userID = $_SESSION['user'][0]->userID;
        $u->username = $user;
        $u->phone = $phone;
        $u->email = $email;
        $u->address = $address;
        
        if($email != $oldEmail)
        {
            if(!empty($u->chk_Email($con)))
                echo "<script>alert('Email đã được đăng kí.');</script>";
            else
            {
                $u->updateUser($con);
                echo "<script>alert('Cập nhật thành công.');
                    window.location.href='index.php'</script>";
            }
        }
        else
        {
            $u->updateUser($con);
            echo "<script>alert('Cập nhật thành công.');
                window.location.href='index.php'</script>";
        }
    }
?>
<?php require "./Layout/header.php"?>
<title>Update Infomation</title>
<?php require "./CSS/register_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card">
          <div class="card-body">
            <h2 class="text-center text-white">CẬP NHẬT THÔNG TIN</h2>
    
            <form action="infoUser.php" method="post">                
                <div class="row m-1 mt-3">
                    <div class="col-md-6 col-12">
                        <label for="username" class="text-white">Tên tài khoản</label>
                        <input class="form-control" id="username" name="username" placeholder="Tên tài khoản" type="text" value="<?= $user?>" required/>
                    </div>
                    
                    <div class="col-md-6 col-12 mt-md-0 mt-4">
                        <label for="phone" class="text-white">Số điện thoại</label>
                        <input class="form-control" id="phone" name="phone" minlength="10" placeholder="Số điện thoại" type="text" value="<?= $phone?>" required/>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <label for="email" class="text-white">Email</label>
                        <input class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?= $email?>" required/>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <label for="address" class="text-white">Địa chỉ</label>
                        <input class="form-control" id="address" name="address" placeholder="Địa chỉ" type="text" value="<?= $address?>" required/>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3 mb-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><input type="submit" id="submit" name="submit" class="form-control" value="CẬP NHẬT" style="width: 100%; margin-top: 0.5rem;" /></div>
                </div>
            </form>
          </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>