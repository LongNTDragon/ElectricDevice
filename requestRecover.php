<?php
    require "config.php";
    require "autoload.php";
    require "send_mail.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>

<?php
    $email = ""; $emailError = ""; $cssEmailError = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $random_number = rand(100, 999);
        $str = password_hash($random_number, PASSWORD_DEFAULT);
        $token = substr($str, 7, 8);
        $email = $_POST['email'];

        $u = new User();
        $u->email = $email;
        $user = $u->chk_Email($con);

        if($user)
        {
            $name = $user[0]->username;
            $userid = $user[0]->userID;
            sendmail_ChangePass($email, $name, $token, $userid);
            $u->token = $token;
            $u->userID = $userid;
            $u->updateToken($con);
            echo '<script>alert("Vui lòng kiểm tra email của bạn.");
                    window.location.href="login.php";</script>';
        }
        else
        {
            $emailError = "Invalid email.";
            $cssEmailError = "box-shadow: 0 0 0.5rem red";
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
                        <input style="<?= $cssEmailError?>" class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?= $email?>" required/>
                        <span style="color:yellow;"><?php echo $emailError;?></span>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3 mb-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><input type="submit" class="form-control" value="KHÔI PHỤC" style="width: 100%; margin-top: 0.5rem;" /></div>
                </div>
            </form>
          </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>