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
?>

<?php
    if(!isset($_GET['proid']))
        header("location:product.php?catID=1");

    $product = new Product();
    $product->proID = $_GET['proid'];
    $pro = $product->getAProductByID($con);

    if(!isset($pro))
        echo '<script>alert("ID không hợp lệ.");
        window.location.href="product.php?catID=1"; </script>';
        
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $cart = new Cart();
        $cart->proID = $pro[0]->proID;
        $dataCart = $cart->checkProduct($con);

        $bD = new BillDetail();
        $bD->proID = $pro[0]->proID;
        $dataBDetail = $bD->checkProduct($con);

        if(!isset($dataCart) && !isset($dataBDetail))
        {
            $p = new Product();
            $p->proID = $pro[0]->proID;
            unlink("." . $pro[0]->image);
            $p->deleteProduct($con);
            echo '<script>alert("Xóa thành công.");
            window.location.href="product.php?catID=' . $pro[0]->catID . '"</script>';
        }
        else
            echo '<script>alert("Không thể xóa sản phẩm này. Sản phẩm đã tồn tại trong giỏ hàng hoặc đơn hàng của người dùng.")</script>';
    }
?>

<?php require "./Layout/header.php"?>
<title>Delete Product</title>

<?php require "../CSS/cart_css.php"?>
<?php require "./menu.php"?>

<div class="text-white text-center container-fluid p-2 pb-3" style="margin-top: 5rem; margin-bottom:3.8rem;
                background-color: rgba(10, 4, 4, 0.9);">

    <h3 class="pt-4">Bạn có chắc là muốn xóa sản phẩm <b class="text-info"><?= $pro[0]->name?></b> ?</h6>
    
    <form action="" method="post" class="p-2">
        <button type="submit" name="submit" class="btn btn-outline-info">Yes</button>
        <a href="product.php?catID=<?=$pro[0]->catID?>" class="btn btn-outline-danger">No</a>
    </form>
</div>

<?php include "./Layout/footer.php" ?>