<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $catID = $_GET['catID'] ?? 1;

    $product = new Product();
    $product->catID = $catID;

    $no_row = count($product->getAll($con));

    $page = $_GET['page'] ?? 1;
    
    $limit = 4;
    $no_page = ($no_row / $limit) + 1;

    if($page < 1)
        header("location:product.php?catID=" . $catID . "&page=1");
    if($page > $no_page)
        header("location:product.php?catID=" . $catID . "&page=" . (int)$no_page);

    $offset = ($page - 1) * $limit;

    $sort = $_GET['sort'] ?? "";
    $data = $product->getProductByPage($con, $limit, $offset, $sort);
    if(empty($data))
        header("location:product.php?catID=" . $catID);
?>

<?php require "./Layout/header.php"?>
<title>Product</title>

<?php require "./CSS/index_css.php"?>

<style>
    body { 
        <?php
            if($catID == 1):
        ?>
                background-image: url('./Image/BG/bground1.png');
        <?php
            elseif($catID == 2):
        ?>
                background-image: url('./Image/BG/bground2.png');
        <?php
            elseif($catID == 3):
        ?>
                background-image: url('./Image/BG/bground3.png');
        <?php
            elseif($catID == 4):
        ?>
                background-image: url('./Image/BG/bground4.png');
        <?php
            elseif($catID == 5):
        ?>
                background-image: url('./Image/BG/bground5.png');
        <?php endif;?>

        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-attachment: fixed;
    } 
</style>

<?php require "./CSS/product_css.php"?>
<?php require "./menu.php"?>

<div class="row container-fluid" style="margin-top: 5rem;">
    <div class="col-md-4"></div>
    <div style="line-height: 3rem;" class="col-md-4 sort text-center">
        <input type="hidden" id="catID" value="<?php echo $catID;?>">
        <span class="text-white">Sắp xếp giá từ </span>
        <select style="margin-left: 1rem;" name="sort" id="sort">
            <?php
                if($sort == "asc"):
            ?>
                    <option value=""></option>
                    <option value="asc" selected>Thấp đến Cao</option>
                    <option value="dsc">Cao đến Thấp</option>
            <?php
                elseif($sort == "dsc"):
            ?>
                    <option value=""></option>
                    <option value="asc">Thấp đến Cao</option>
                    <option value="dsc" selected>Cao đến Thấp</option>
            <?php
                else:
            ?>
                    <option value="" selected></option>
                    <option value="asc">Thấp đến Cao</option>
                    <option value="dsc">Cao đến Thấp</option>
            <?php endif;?>
        </select>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="row row-cols-sm-2 row-cols-md-4 g-0">
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

<div>
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $page-1?>&sort=<?= $sort?>">
                <i class="fa-duotone fa-backward"></i>
            </a>
        </li>
        <?php
            for($i = 1; $i <= $no_page; $i++):
                if($i == $page):
        ?>
                <li class="page-item active">
                    <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $i?>&sort=<?= $sort?>">
                        <?= $i?>
                    </a>
                </li>
            <?php else:?>
                <li class="page-item">
                    <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $i?>&sort=<?= $sort?>">
                    <?= $i?>
                    </a>
                </li>
            <?php endif;?>
        <?php endfor;?>
        <li class="page-item active">
            <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $page+1?>&sort=<?= $sort?>">
                <i class="fa-duotone fa-forward"></i>
            </a>
        </li>
    </ul>
</div>

<?php include "./Layout/footer.php" ?>

<script>
    var catID = document.getElementById('catID').value;
    $("#sort").change(function (){
        const value = $("#sort").val();
        window.location.href = "product.php?catID=" + catID + "&sort=" + value;
    })
</script>
