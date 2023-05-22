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
    $b = new Bill();

    if(!isset($_GET['billID']))
        header("location:bill.php");
        
    $b->billID = $_GET['billID'];

    $billArr = $b->getABill($con);
    if(empty($billArr))
        header("location:bill.php");
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $bill = new Bill();
        $bill->billID = $billArr[0]->billID;
        $bill->updateBill($con);
        echo '<script>alert("Cập nhật thành công.");
            window.location.href="bill.php"</script>';
    }
?>

<?php require "./Layout/header.php"?>
<title>Update Bill</title>

<?php require "../CSS/cart_css.php"?>
<?php require "./menu.php"?>

<div class="text-white text-center container-fluid p-2 pb-3" style="margin-top: 5rem; margin-bottom:3.8rem;
                background-color: rgba(10, 4, 4, 0.9);">

    <h3 class="pt-4">Xác nhận đơn hàng <b class="text-info"><?= $billArr[0]->billID?></b> đã được giao</h6>
    
    <form action="" method="post" class="p-2">
        <button type="submit" name="submit" class="btn btn-outline-info">Yes</button>
        <a href="bill.php" class="btn btn-outline-danger">No</a>
    </form>
</div>

<?php include "./Layout/footer.php" ?>