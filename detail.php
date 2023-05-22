<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $id = $_GET['proid'] ?? 1;
    $product = new Product();
    $product->proID = $id;
    $pro = $product->getAProductByID($con);

    if(!isset($pro))
        echo '<script>alert("ID không hợp lệ.");
        window.location.href="index.php"; </script>';
?>

<?php
    if(isset($_GET['action']) && isset($_GET['proid']))
    {
        $action = $_GET['action'];
        $proid = $_GET['proid'];

        if(!isset($_SESSION['user']))
        {
            echo '<script>alert("Bạn phải đăng nhập để thực hiện chức năng này.");
            window.location.href="login.php"; </script>';
        }
        else
        {
            if($action == "addcart")
            {
                $product->proID = $proid;
                $p = $product->getAProductByID($con);

                if($p)
                {
                    $cart = new Cart();
                    $cart->userID = $_SESSION['user'][0]->userID;
                    $cart->proID = $proid;

                    $cartArr = $cart->findProductOfUser($con);
                    if(isset($cartArr))
                    {
                        $cart->quantity = $cartArr[0]->quantity + 1;
                        $cart->updateQuantity($con);
                    }
                    else
                    {
                        $cart->quantity = 1;
                        $cart->addProduct($con);
                    }
                }
                header("location:cart.php");
            }
        }
    }
?>

<?php require "./Layout/header.php"?>
<title>Detail Product</title>

<?php require "./CSS/detail_css.php"?>
<?php require "./menu.php"?>

<div class="container-fluid text-white" style="margin-top: 5rem; background-color: rgba(10, 4, 4, 0.5);">
    <div class="row p-2">
        <marquee scrollamount="10">
            <span class="text-info">
                Bạn đang ở : Trang chủ <i class="fa-solid fa-caret-right"></i>
                Chi tiết sản phẩm <i class="fa-solid fa-caret-right"></i> <?= $pro[0]->name?>
            </span>
        </marquee>
    </div>

    <div class="row m-2">
        <div class="col-md-5 mb-3">
            <div>
                <img style="width: 100%; border-radius: 20px;" src="<?= $pro[0]->image?>" alt="Alternate Text" />
            </div>
        </div>

        <div class="col-md-7" style="font-size:1.5rem;">
            <div style="border-bottom: 2px solid white;">
                <h3 class="text-info"><?= $pro[0]->name?></h3>
                <p><b>Thông tin chung: </b></p>
                <ul class="m-3">
                    <li><b>Tình trạng : </b><span><?= $pro[0]->status?></span></li>
                    <li><b>Bảo hành : </b><span><?= $pro[0]->insurance?></span> tháng</li>
                </ul>
            </div>

            <div style="border-bottom: 2px solid white;">
                <h3 class="text-info p-2">ƯU ĐÃI KHI MUA THÊM</h3>
                <p><i class="fa-solid fa-star text-info"></i> Giảm <b>200,000đ</b> trên tổng hóa đơn khi mua hàng tại shop.</p>
                <p><i class="fa-solid fa-star text-info"></i> Giảm <b>150,000đ</b> khi mua trên 2 sản phẩm.</p>
            </div>

            <div class="mb-3">
                <p class="p-2">Giá : <b class="text-info"><?= number_format($pro[0]->price, 0, ",", ".")?><span>đ</span></b></p>
                <a href="detail.php?action=addcart&proid=<?= $pro[0]->proID?>" class="btn btn-info text-white">ĐẶT HÀNG</a>
            </div>
        </div>
    </div>
</div>

<?php include "./Layout/footer.php" ?>