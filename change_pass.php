<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(!isset($_GET['userid']) || !isset($_GET['token']))
        header("location:index.php");
    
    $userid = $_GET['userid'];
    $token = $_GET['token'];

    $u = new User();
    $u->userID = $userid;
    $user = $u->getAUserByID($con);
    if(!isset($user))
        header("location:index.php");
    else
    {
        if($user[0]->token != $token)
            header("location:index.php");
        else
        {
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $start = date_create($user[0]->recovertime);
            $end = date_create(date("Y-m-d H:i:s"));
            $diff=date_diff($end,$start);
            $result = $diff->h * 60 + $diff->i;
            if($result > 2)
            {
                echo "<script>alert('Đường link này đã hết hạn.'); 
                    window.location.href='requestRecover.php';</script>";
            }
        }
    }
?>

<?php
    $pass = ""; $passCon = "";
    $confirmPWError = ""; $cssConError = "";

    if(isset($_POST['submit']))
    {
        $pass = $_POST["pwNew"];
        $passCon = $_POST["confirmPW"];

        if($passCon != $pass)
        {
            $confirmPWError = "Mật khẩu không trùng khớp.";
            $cssConError = "box-shadow: 0 0 0.5rem red";
        }
        else
        {
            $u = new User();
            $u->password = password_hash($pass, PASSWORD_DEFAULT);
            $u->userID = $userid;
            
            $u->updatePass($con);
            echo "<script>alert('Cập nhật thành công.');
                window.location.href='login.php'</script>";
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
    
            <form action="" method="post">                
                <div class="row m-1 mt-3">
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