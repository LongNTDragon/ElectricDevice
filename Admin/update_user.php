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
        header("location:users.php");
        
    $u->userID = $_GET['userID'];

    $data = $u->getAUserByID($con);
    if(empty($data))
        header("location:users.php");
        
    if($data[0]->username == "admin")
    {
        echo "<script>alert('Không thể chỉnh sửa tài khoản này.');
                window.location.href='users.php'</script>";
    }
?>

<?php
    $user = $data[0]->username; $userError = ""; $cssUserError = "";
    $phone = $data[0]->phone; 
    $pass = $data[0]->password;
    $email = $data[0]->email; $emailError = ""; $cssEmailError = "";
    $address = $data[0]->address;
    $role = $data[0]->roleID;

    if(isset($_POST['submit']))
    {
        $user = $_POST["username"];
        $phone = $_POST["phone"];
        $pass = $_POST["password"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $role = $_POST["role"];

        $us = new User();
        $us->userID = $data[0]->userID;
        $us->username = $user;
        $us->password = password_hash($pass, PASSWORD_DEFAULT);
        $us->phone = $phone;
        $us->email = $email;
        $us->address = $address;
        $us->roleID = $role;
        
        if($us->username != $data[0]->username)
        {
            if(!empty($us->chk_Username($con)))
            {
                $userError = '<i class="fa-solid fa-triangle-exclamation"></i> Username already exists.';
                $cssUserError = "box-shadow: 0 0 0.5rem red";
            }
        }
        if($us->email != $data[0]->email)
        {
            if(!empty($us->chk_Email($con)))
            {
                $emailError = '<i class="fa-solid fa-triangle-exclamation"></i> Email already exists.'; 
                $cssEmailError = "box-shadow: 0 0 0.5rem red";
            }
        }

        if($userError == "" && $emailError == "")
        {
            $us->updateUserAdmin($con);
            echo "<script>alert('Cập nhật thành công.');
                window.location.href='users.php'</script>";  
        }
    }
?>
<?php require "./Layout/header.php"?>
<title>Update User</title>
<?php require "../CSS/register_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card bg-black">
          <div class="card-body">
            <h2 class="text-center text-white">CẬP NHẬT NGƯỜI DÙNG</h2>
            
            <form action="" method="post">                
                <div class="row m-1 mt-3">
                    <div class="col-md-6">
                        <label for="username" class="text-white">Tên tài khoản</label>
                        <input style="<?= $cssUserError?>" class="form-control" id="username" name="username" placeholder="Tên tài khoản" type="text" value="<?= $user?>" required/>
                        <span style="color:yellow;"><?= $userError?></span>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="phone" class="text-white">Số điện thoại</label>
                        <input class="form-control" id="phone" name="phone" minlength="10" placeholder="Số điện thoại" type="text" value="<?= $phone?>" required/>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-6">
                        <label for="password" class="text-white">Mật khẩu</label>
                        <input class="form-control" id="password" name="password" placeholder="Mật khẩu" type="password" value="<?= $pass?>" required/>
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="text-white">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <?php
                                if($role == "1"):
                            ?>    
                                    <option value="1" selected>Admin</option>
                                    <option value="2">User</option>
                            <?php
                                else:
                            ?> 
                                    <option value="1">Admin</option>
                                    <option value="2" selected>User</option>
                            <?php
                                endif;
                            ?> 
                        </select>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <label for="email" class="text-white">Email</label>
                        <input style="<?= $cssEmailError?>" class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?= $email?>" required/>
                        <span style="color:yellow;"><?= $emailError?></span>
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