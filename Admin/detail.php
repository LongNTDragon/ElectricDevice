<?php
    require "../Class/Database.php";
    require "autoload.php";
    session_start();

    if(!isset($_SESSION['user']))
        header("location:../index.php");

    $con = Database::connectDB();

    $id = $_GET['proid'] ?? 1;
    $product = new Product();
    $product->proID = $id;
    $pro = $product->getAProductByID($con);

    if(!isset($pro))
        echo '<script>alert("ID không hợp lệ.");
        window.location.href="index.php"; </script>';
?>

<?php require "./Layout/header.php"?>
<title>Detail Product</title>

<?php require "../CSS/detail_css.php"?>
<?php require "./menu.php"?>

<div class="container-fluid text-white" style="margin-top: 5rem; background-color: rgba(10, 4, 4, 1);">
    <div class="row m-3">
        <div class="col-md-5 mb-3 mt-3">
            <div>
                <img style="width: 100%; border-radius: 20px;" src="<?="." . $pro[0]->image?>" alt="Alternate Text" />
            </div>
        </div>

        <div class="col-md-6 mt-4 ms-3" style="font-size:1.5rem;">
            <div style="border-bottom: 2px solid white;">
                <h3 class="text-info"><?= $pro[0]->name?></h3>
                <p><b>Thông tin chung: </b></p>
                <ul class="m-3">
                    <li><b>Tình trạng : </b><span><?= $pro[0]->status?></span></li>
                    <li><b>Bảo hành : </b><span><?= $pro[0]->insurance?></span> tháng</li>
                </ul>
            </div>

            <div class="mb-3">
                <p class="p-2">Giá : <b class="text-info"><?= number_format($pro[0]->price, 0, ",", ".")?><span>đ</span></b></p>
                <a href="product.php?catID=<?= $pro[0]->catID?>" class="btn btn-info text-white">VỀ TRANG SẢN PHẨM</a>
            </div>
        </div>
    </div>
</div>

<?php include "./Layout/footer.php" ?>