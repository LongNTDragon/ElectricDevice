<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $c = new Cart();

    if(isset($_SESSION['user']))
    {
        $c->userID = $_SESSION['user'][0]->userID;
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $c->proID = $_POST['proid'];
            $c->quantity = $_POST['quantity'];
            
            $c->updateQuantity($con);
        }

        $cartArr = $c->getAllProductOfUser($con);
    }
?>

<?php require "./Layout/header.php"?>
<title>Shopping Cart</title>

<?php require "./CSS/cart_css.php"?>
<?php require "./menu.php"?>

<div class="text-white container-fluid" style="margin-top: 5rem;
                background-color: rgba(10, 4, 4, 0.5);">
    <?php
        if(!isset($cartArr)) :
    ?>
            <div class="text-center" style="min-height:185px;">
                <h3 class="pt-4">Không có sản phẩm nào trong giỏ hàng!</h6>
                <a href="index.php" class="text-info" style="text-decoration:none;">
                    <i class="fa-solid fa-reply"></i> 
                    Tiếp tục mua hàng
                </a>
            </div>
    <?php
        else :
    ?>
            
            <table class="table text-center table-bordered text-white">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                    <th>Cập nhật <i class="fa-regular fa-pipe" style="margin: 0 0.5rem;"></i> Xóa</th>
                </tr>
                <?php
                    foreach($cartArr as $cart):
                        $pro = new Product();
                        $pro->proID = $cart->proID;
                        $product = $pro->getAProductByID($con);
                ?>
                
                        <tr style="line-height:10rem;">
                            <form action="" method="post">
                                <td class="w-25"><img style="width:50%;" src="<?= $product[0]->image?>"></td>
                                <td class="text-info">
                                    <b style="text-shadow: 0.5px 0.5px 0.1rem white;"><?= $product[0]->name?></b>
                                </td>

                                <td style="width:20%;">
                                    <input class="h-25 w-25" style="width:20%;" type="number" name="quantity" value="<?= $cart->quantity?>" min="1"/>
                                    <input type="hidden" name="proid" value="<?= $cart->proID?>"/>
                                </td>

                                <td><?= number_format($product[0]->price, 0, ",", ".")?>đ</td>
                                <td style="width:12%;">
                                    <button type="submit" name="submit" class="btn btn-outline-info">
                                        <i class="fa-solid fa-rotate"></i>
                                    </button>
                                    <i class="fa-regular fa-pipe" style="margin: 0 0.5rem;"></i>
                                    <a href="removeCartItem.php?proid=<?= $cart->proID?>" class="btn btn-outline-danger">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </form>
                        </tr>
                <?php endforeach?>
                <tr>
                    <td colspan="3"><b>TOTAL</b></td>
                    <td colspan="2">
                        <?php
                            $sum = 0;
                            foreach($cartArr as $cart)
                            {
                                $pro = new Product();
                                $pro->proID = $cart->proID;
                                $product = $pro->getAProductByID($con);
                                $sum += ($cart->quantity * $product[0]->price);
                            }
                            echo number_format($sum, 0, ",", ".") ."đ"
                        ?>
                    </td>
                </tr>
            </table>
            
            <div class="text-center">
                <a href="payments.php" class="btn btn-info text-white mb-3">THANH TOÁN</a>
            </div>

        <?php endif?>
</div>

<?php include "./Layout/footer.php" ?>