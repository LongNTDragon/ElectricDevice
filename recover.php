<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 ?>

<?php
    $email = "";  $emailError = ""; $cssError = "";
    $newPass = "";

    if(isset($_POST['submit']))
    {
        $email = $_POST["email"];

        $u = new User();
        $u->email = $email;

        $data = $u->chk_Email($con);
        if(!empty($data))
        {
            $newPass = substr($data[0]->password, -8);
            $u->userID = $data[0]->userID;
            $u->password = password_hash($newPass, PASSWORD_DEFAULT);
            $u->updatePass($con);
        }
        else
        {
            $emailError = '<i class="fa-solid fa-triangle-exclamation"></i> Email does not exist.';
            $cssError = "box-shadow: 0 0 0.5rem red";
        }
    }
?>
<?php require "./Layout/header.php"?>
<title>Recovery Password</title>
<?php require "./CSS/register_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card">
          <div class="card-body">
            <h2 class="text-center text-white">KHÔI PHỤC MẬT KHẨU</h2>
    
            <form action="recover.php" method="post">                
                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <input style="<?= $cssEmailError?>" class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?= $email?>" required/>
                        <span style="color:yellow;"><?= $emailError?></span>
                    </div>
                </div>

                <div class="row m-1 mt-2">
                    <div class="col-md-12 text-center">
                        <span style="color:yellow;"><?php echo $newPass?></span>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3 mb-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><input type="submit" id="submit" name="submit" class="form-control" value="KHÔI PHỤC" style="width: 100%; margin-top: 0.5rem;" /></div>
                </div>
            </form>
          </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>