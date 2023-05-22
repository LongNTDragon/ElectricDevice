<?php
    require "config.php";
    require "autoload.php";
    session_start();
    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>

<?php
  if(isset($_POST["submit"]))
  {
      $user = $_POST["userName"];
      $pass = $_POST["passWord"];

      $u = new User();
      $u->username = $user;
      $u->password = $pass;

      if(!empty($u->chk_UserAndPass($con)))
      {
        $_SESSION['user'] = $u->chk_UserAndPass($con);
        if($_SESSION['user'][0]->roleID == 2)
          header("location:index.php");
        else
          header("location:./Admin/index.php");
      }
      else
      {
        echo "<script>alert('Login fail.'); 
        window.location.href='login.php';</script>";
      }
  }
?>

<?php require "./Layout/header.php"?>
<title>Login</title>
<?php require "./CSS/login_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
      <div class="col-md-3 col-sm-1"></div>
      <div class="col-md-6 col-sm-10 mt-4 card">
        <div class="card-body">
          <h2 class="text-center text-white">ĐĂNG NHẬP</h2>
  
          <form action="login.php" method="post">                
            <div class="row w-75 mx-auto">
              <div class="col-md-12 mt-3">
                <input class="form-control" id="userName" name="userName" placeholder="Tên tài khoản" type="text" required/>
              </div>
            
              <div class="col-md-12 mt-3">
                <input class="form-control" id="passWord" name="passWord" placeholder="Mật khẩu" type="password" required/>
              </div>
            </div>

            <div class="row w-75 mx-auto p-2 text-center mt-3">
              <div class="col-md-4"></div>
              <div class="col-md-4 text-center"><input type="submit" id="submit" name="submit" class="form-control" value="ĐĂNG NHẬP" /></div>

              <p class="text-center text-white mt-4">
                Bạn chưa có tài khoản?<a href="register.php" class="link-info"> Đăng ký ở đây</a> <br />
                <a href="requestRecover.php" class="text-danger text-decoration-none">Quên mật khẩu</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>

<?php require "./Layout/footer.php" ?>