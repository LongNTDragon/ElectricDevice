<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>

<?php
    if(!isset($_GET['proid']) || !isset($_SESSION['user']))
        header("location:index.php");

    $product = new Product();
    $product->proID = $_GET['proid'];
    $pro = $product->getAProductByID($con);
        
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $cart = new Cart();
        $cart->userID = $_SESSION['user'][0]->userID;
        $cart->proID = $pro[0]->proID;
        
        $cart->deleteProduct($con);
        header("location:cart.php");
    }
?>

<?php require "./Layout/header.php"?>
<title>Delete CartItem</title>

<?php require "./CSS/cart_css.php"?>
<?php require "./menu.php"?>

<div class="text-white text-center container-fluid p-2 pb-3" style="margin-top: 5rem;
                background-color: rgba(10, 4, 4, 0.5);">

    <h3 class="pt-4">Bạn có chắc là muốn xóa sản phẩm <b class="text-info"><?= $pro[0]->name?></b> ra khỏi giỏ hàng</h6>
    
    <form action="" method="post" class="p-2">
        <button type="submit" name="submit" class="btn btn-outline-info">Yes</button>
        <a href="cart.php" class="btn btn-outline-danger">No</a>
    </form>
</div>

<?php include "./Layout/footer.php" ?>