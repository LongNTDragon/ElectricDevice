<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $product = new Product();
    $data = null;
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $str = $_POST['search'];
        if(!empty($str))
        {
            $result = $product->findProduct($con, $str);
            if(!isset($result))
            {
                echo '<script>alert("Không tìm thấy sản phẩm nào.");
                    window.location.href="index.php"; </script>';
            }
            $data = $result;
        }
        else
        {
                header("location:index.php");
        }
    }
?>

<?php require "./Layout/header.php"?>
<title>Product</title>

<?php require "./CSS/index_css.php"?>

<style>
    body { 
        background-image: url('./Image/BG/bground1.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-attachment: fixed;
    } 
</style>

<?php require "./CSS/product_css.php"?>
<?php require "./menu.php"?>

<div class="row row-cols-sm-2 row-cols-md-4 g-0" style="margin-top: 5rem;">
    <?php 
        foreach($data as $row):
    ?>
            <div class="card m-3" style="width:15.85rem;">
                <a href="detail.php?proid=<?= $row->proID?>">
                    <img src="<?= $row->image?>" class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                    <div style="min-height:3rem;">
                        <h6 class="card-title" style="font-size:1.1rem;"><?= $row->name?></h6>
                    </div>
                    <p class="card-text">Giá : <span class="text-danger"><?= number_format($row->price, 0, ",", ".")?><span>đ</span></span></p>
                </div>
                <div class="detail_pro pt-2 w-100">
                    <i class="text-white">Click để xem chi tiết</i>
                    <span><a href="detail.php?proid=<?= $row->proID?>" class="btn btn-outline-light h-75 ms-3">Đặt hàng</a></span>
                </div>
            </div>
    <?php endforeach?>
</div>

<?php include "./Layout/footer.php" ?>

<script>
    var catID = document.getElementById('catID').value;
    $("#sort").change(function (){
        const value = $("#sort").val();
        window.location.href = "product.php?catID=" + catID + "&sort=" + value;
    })
</script>
