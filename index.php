<?php
    require "config.php";
    require "autoload.php";
    session_start();

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $product = new Product();
?>

<?php require "./Layout/header.php"?>
<title>Home</title>

<?php require "./CSS/index_css.php"?>
<?php require "./menu.php"?>

<div class="row container-fluid" style="margin-top: 5rem;">
    <div class="col-md-8 ps-4 ps-md-2">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-mdb-interval="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="product.php?catID=1"><img src="./Image/Slide/slide1.png" class="d-block w-100" alt="..."></a>
                </div>
                <div class="carousel-item">
                    <a href="product.php?catID=5"><img src="./Image/Slide/slide2.png" class="d-block w-100" alt="..."></a>
                </div>
                <div class="carousel-item">
                    <a href="product.php?catID=3"><img src="./Image/Slide/slide3.png" class="d-block w-100" alt="..."></a>
                </div>
                <div class="carousel-item">
                    <a href="product.php?catID=4"><img src="./Image/Slide/slide4.png" class="d-block w-100" alt="..."></a>
                </div>
                <div class="carousel-item">
                    <a href="product.php?catID=1"><img src="./Image/Slide/slide5.png" class="d-block w-100" alt="..."></a>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    
    <div class="col-md-4 d-none d-sm-none d-md-block">
        <div class="solid">
            <a href="product.php?catID=5">
                <img src="./Image/solid/solid1.png" alt="Alternate Text" />
            </a>
        </div>
        <div class="solid mt-3">
            <a href="product.php?catID=2">
                <img src="./Image/solid/solid2.png" alt="Alternate Text" />
            </a>
        </div>
    </div>
</div>

<div class="row row-cols-sm-2 row-cols-md-3 container-fluid mt-4">
    <div class="solid ps-4">
        <a href="product.php?catID=5">
            <img src="./Image/solid/solid3.png" alt="Alternate Text" />
        </a>
    </div>
    <div class="solid ps-4">
        <a href="product.php?catID=4">
            <img src="./Image/solid/solid4.png" alt="Alternate Text" />
        </a>
    </div>
    <div class="solid ps-4">
        <a href="product.php?catID=1">
            <img src="./Image/solid/solid5.png" alt="Alternate Text" />
        </a>
    </div>
</div>

<div class="container-fluid title mt-2 mb-1">
    <div class="row title-text">
        <div class="col-9 col-md-10"><h3 class="m-2">PC BAOLONG - MIỄN PHÍ GIAO HÀNG TOÀN QUỐC</h3></div>
        <div class="col-3 col-md-2"><a href="product.php?catID=1" class="text-white"><p id="watchall" class="m-3" style="float: right;">Xem tất cả <i class="fa-solid fa-caret-right"></i></p></a></div>
    </div>
</div>

<div class="row row-cols-sm-2 row-cols-md-4 g-0">
    <?php 
        $product->catID = 1;
        $data = $product->getAllNewProductByCatID($con);

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

<div class="container-fluid title mt-2 mb-1">
    <div class="row title-text">
        <div class="col-9 col-md-10"><h3 class="m-2">LAPTOP - GIAO HÀNG MIỄN PHÍ</h3></div>
        <div class="col-3 col-md-2"><a href="product.php?catID=2" class="text-white"><p id="watchall" class="m-3" style="float: right;">Xem tất cả <i class="fa-solid fa-caret-right"></i></p></a></div>
    </div>
</div>

<div class="row row-cols-sm-2 row-cols-md-4 g-0">
    <?php 
        $product->catID = 2;
        $data = $product->getAllNewProductByCatID($con);

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

<div class="container-fluid title mt-2 mb-1">
    <div class="row title-text">
        <div class="col-9 col-md-10"><h3 class="m-2">CHUỘT - MIỄN PHÍ GIAO HÀNG TOÀN QUỐC</h3></div>
        <div class="col-3 col-md-2"><a href="product.php?catID=3" class="text-white"><p id="watchall" class="m-3" style="float: right;">Xem tất cả <i class="fa-solid fa-caret-right"></i></p></a></div>
    </div>
</div>

<div class="row row-cols-sm-2 row-cols-md-4 g-0">
    <?php 
        $product->catID = 3;
        $data = $product->getAllNewProductByCatID($con);

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

<div class="container-fluid title mt-2 mb-1">
    <div class="row title-text">
        <div class="col-9 col-md-10"><h3 class="m-2">MÀN HÌNH - GIAO HÀNG MIỄN PHÍ</h3></div>
        <div class="col-3 col-md-2"><a href="product.php?catID=4" class="text-white"><p id="watchall" class="m-3" style="float: right;">Xem tất cả <i class="fa-solid fa-caret-right"></i></p></a></div>
    </div>
</div>

<div class="row row-cols-sm-2 row-cols-md-4 g-0">
    <?php 
        $product->catID = 4;
        $data = $product->getAllNewProductByCatID($con);

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

<div class="container-fluid title mt-2 mb-1">
    <div class="row title-text">
        <div class="col-9 col-md-10"><h3 class="m-2">BÀN PHÍM - MIỄN PHÍ GIAO HÀNG TOÀN QUỐC</h3></div>
        <div class="col-3 col-md-2"><a href="product.php?catID=5" class="text-white"><p id="watchall" class="m-3" style="float: right;">Xem tất cả <i class="fa-solid fa-caret-right"></i></p></a></div>
    </div>
</div>

<div class="row row-cols-sm-2 row-cols-md-4 g-0">
    <?php 
        $product->catID = 5;
        $data = $product->getAllNewProductByCatID($con);

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