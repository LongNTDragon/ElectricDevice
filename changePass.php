<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(!isset($_SESSION['user']))
        header("location:index.php");
?>

<?php
    $oldPass = ""; $passOldErr = ""; $cssError = "";
    $pass = ""; $passCon = "";
    $confirmPWError = ""; $cssConError = "";

    if(isset($_POST['submit']))
    {
        $oldPass = $_POST["pwOld"];
        $pass = $_POST["pwNew"];
        $passCon = $_POST["confirmPW"];

        if(!password_verify($oldPass, $_SESSION['user'][0]->password))
        {
            $passOldErr = "Mật khẩu cũ không đúng.";
            $cssError = "box-shadow: 0 0 0.5rem red";
        }
        else
        {
            if($passCon != $pass)
            {
                $confirmPWError = "Mật khẩu không trùng khớp.";
                $cssConError = "box-shadow: 0 0 0.5rem red";
            }
            else
            {
                $u = new User();
                $u->password = password_hash($pass, PASSWORD_DEFAULT);
                $u->userID = $_SESSION['user'][0]->userID;
                
                $u->updatePass($con);
                echo "<script>alert('Cập nhật thành công.');
                    window.location.href='index.php'</script>";
            }
        }
    }
?>
<?php require "./Layout/header.php"?>
<title>Change Password</title>
<?php require "./CSS/register_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card">
          <div class="card-body">
            <h2 class="text-center text-white">THAY ĐỔI MẬT KHẨU</h2>
    
            <form action="changePass.php" method="post">                
                <div class="row m-1 mt-3">
                    <div class="col-md-12">
                        <input style="<?= $cssError?>" class="form-control" id="pwOld" name="pwOld" placeholder="Mật khẩu cũ" type="password" value="<?= $oldPass?>" required/>
                        <span style="color:yellow;"><?= $passOldErr?></span>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <input class="form-control" id="pwNew" name="pwNew" placeholder="Mật khẩu mới" type="password" value="<?= $pass?>" required/>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <input style="<?= $cssConError?>" class="form-control" id="confirmPW" name="confirmPW" placeholder="Nhập lại mật khẩu mới"  type="password" value="<?= $passCon?>" required/>
                        <span style="color:yellow;"><?= $confirmPWError?></span>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3 mb-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><input type="submit" id="submit" name="submit" class="form-control" value="LƯU" style="width: 100%; margin-top: 0.5rem;" /></div>
                </div>
            </form>
          </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>