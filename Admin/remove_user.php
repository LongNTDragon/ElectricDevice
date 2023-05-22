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
        echo "<script>alert('Không thể xóa tài khoản này.');
                window.location.href='users.php'</script>";
    }
?>

<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user = new User();
        $user->userID = $data[0]->userID;
        $user->deleteUser($con);
        echo '<script>alert("Xóa thành công.");
            window.location.href="users.php"</script>';
    }
?>

<?php require "./Layout/header.php"?>
<title>Delete User</title>

<?php require "../CSS/cart_css.php"?>
<?php require "./menu.php"?>

<div class="text-white text-center container-fluid p-2 pb-3" style="margin-top: 5rem; margin-bottom:3.8rem;
                background-color: rgba(10, 4, 4, 0.9);">

    <h3 class="pt-4">Bạn có chắc là muốn xóa người dùng <b class="text-info"><?= $data[0]->username?></b> ?</h6>
    
    <form action="" method="post" class="p-2">
        <button type="submit" name="submit" class="btn btn-outline-info">Yes</button>
        <a href="users.php" class="btn btn-outline-danger">No</a>
    </form>
</div>

<?php include "./Layout/footer.php" ?>