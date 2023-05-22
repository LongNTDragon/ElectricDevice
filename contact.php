<?php
  require "config.php";
  require "autoload.php";
  require "send_mail.php";
  session_start();

  $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name = $_POST['username'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $result = sendmai_Contact($email, $name, $message);
        if($result == "true")
            sendmail_Feedback($email, $name);

        echo '<script>alert("Gửi thành công");
                window.location.href="index.php";</script>';
    }
?>

<?php require "./Layout/header.php"?>
<title>Contact</title>
<?php require "./CSS/login_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card">
            <div class="card-body">
            <h2 class="text-center text-white">LIÊN HỆ VỚI CHÚNG TÔI</h2>
    
            <form action="" method="post">                
                <div class="row w-75 mx-auto">
                    <div class="col-md-12 mt-3">
                        <label for="username" class="form-label text-white">Họ và tên</label>
                        <input class="form-control" id="username" name="username" type="text" required/>
                    </div>
                    
                    <div class="col-md-12 mt-3">
                        <label for="email" class="form-label text-white">Email</label>
                        <input class="form-control" id="email" name="email" type="email" required/>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label for="message" class="form-label text-white">Nội dung</label>
                        <textarea class="form-control" name="message" id="message" cols="30" rows="10" required></textarea>
                    </div>
                </div>

                <div class="row w-75 mx-auto p-2 text-center mt-3">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center"><input type="submit" class="form-control" value="GỬI" /></div>
                </div>
            </form>
            </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>