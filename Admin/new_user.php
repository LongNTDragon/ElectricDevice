<?php
  require "../Class/Database.php";
  require "./autoload.php";

  $con = Database::connectDB();
?>

<?php
    $user = ""; $userError = ""; $cssUserError = "";
    $pass = "";
    $confirmPWError = ""; $passCon = ""; $cssError = "";
    $email = ""; $emailError = ""; $cssEmailError = "";

    if(isset($_POST['submit']))
    {
        $user = $_POST["username"];
        $pass = $_POST["password"];
        $passCon = $_POST["confirmPW"];
        $email = $_POST["email"];

        if($passCon != $pass)
        {
            $confirmPWError = '<i class="fa-solid fa-triangle-exclamation"></i> Password and Confirm Password are not the same.';
            $cssError = "box-shadow: 0 0 0.5rem red";
        }
        else
        {
            $u = new User();
            $u->username = $user;
            $u->password = password_hash($pass, PASSWORD_DEFAULT);
            $u->email = $email;

            if(!empty($u->chk_Username($con)))
            {
                $userError = '<i class="fa-solid fa-triangle-exclamation"></i> Username already exists.';
                $cssUserError = "box-shadow: 0 0 0.5rem red";
            }
            else
            {
                if(!empty($u->chk_Email($con)))
                {
                    $emailError = '<i class="fa-solid fa-triangle-exclamation"></i> Email already exists.'; 
                    $cssEmailError = "box-shadow: 0 0 0.5rem red";
                }
                else
                {
                    if($u->addUser($con) > 0)
                        header("location:login.php");
                    else
                        echo "<script>alert('Register fail.');</script>";
                }
            }
        }
    }
?>
<?php require "./Layout/header.php"?>
<title>New User</title>
<?php require "../CSS/register_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card bg-black">
          <div class="card-body">
            <h2 class="text-center text-white">THÊM NGƯỜI DÙNG</h2>
    
            <form action="" method="post">                
                <div class="row m-1 mt-3">
                    <div class="col-md-6">
                        <input style="<?= $cssUserError?>" class="form-control" id="username" name="username" placeholder="Tên tài khoản" type="text" value="<?= $user?>" required/>
                        <span style="color:yellow;"><?= $userError?></span>
                    </div>
                    
                    <div class="col-md-6">
                        <input style="<?= $cssEmailError?>" class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?= $email?>" required/>
                        <span style="color:yellow;"><?= $emailError?></span>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-6">
                        <input class="form-control" id="password" name="password" placeholder="Mật khẩu" type="password" value="<?= $pass?>" required/>
                    </div>

                    <div class="col-md-6 mt-md-0 mt-4">
                        <input style="<?= $cssError?>" class="form-control" id="confirmPW" name="confirmPW" placeholder="Nhập lại mật khẩu"  type="password" value="<?= $passCon?>" required/>
                        <span style="color:yellow;"><?= $confirmPWError?></span>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3 mb-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><input type="submit" id="submit" name="submit" class="form-control" value="TẠO" /></div>
                </div>
            </form>
          </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>