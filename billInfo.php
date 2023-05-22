<?php
    require "config.php";
    require "autoload.php";
    session_start();

    if(!isset($_SESSION['user']))
    {
        echo "<script>alert('Bạn chưa đăng nhập.');
        window.location.href='login.php'</script>";
    }

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $b = new Bill();
    $b->userID = $_SESSION['user'][0]->userID;
    $billArray = $b->getAllBillOfUser($con);
?>

<?php require "./Layout/header.php"?>
<title>Bill Infomation</title>

<?php require "./CSS/cart_css.php"?>
<?php require "./menu.php"?>

<div class="text-white container-fluid" style="margin-top: 5rem;
                background-color: rgba(10, 4, 4, 0.5);">
    <?php
        if(!isset($billArray)) :
    ?>
            <div class="text-center" style="min-height:185px;">
                <h3 class="pt-4">Không có đơn hàng nào được đặt!</h6>
                <a href="index.php" class="text-info" style="text-decoration:none;">
                    <i class="fa-solid fa-reply"></i> 
                    Tiếp tục mua hàng
                </a>
            </div>
    <?php
        else :
            foreach($billArray as $bill):
                $bD = new BillDetail();
                $bD->billID = $bill->billID;
                $bDArray = $bD->getAllProductByID($con);
    ?>
                <div class="row w-100 mx-auto text-center">
                    <div class="col-md-12 mt-2">
                        <h3 class="text-info">Số HD: <?php echo $bill->billID;?></h3>
                    </div>
                </div>

                <div class="row w-100 mx-auto mt-2 text-center">
                    <div class="col-md-6">
                        <h3 class="text-info">
                            Ngày đặt: 
                            <?php 
                                $dt = new DateTime($bill->createdDate);
                                echo $dt->format('d/m/Y') .' - '. $dt->format('H:i:s');
                            ?>
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-info">
                            Ngày nhận: 
                            <?php
                                if(!isset($bill->receivedDate))
                                    echo "Dự kiến sau 3-4 kể từ ngày đặt";
                                else
                                {
                                    $dt = new DateTime($bill->receivedDate);
                                echo $dt->format('d/m/Y') .' - '. $dt->format('H:i:s');
                                }
                            ?>
                        </h3>
                    </div>
                </div>

                <table class="table text-center table-bordered text-white">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá tiền</th>
                    </tr>
                    <?php
                        foreach($bDArray as $row):
                            $pro = new Product();
                            $pro->proID = $row->proID;
                            $product = $pro->getAProductByID($con);
                    ?>
                    
                            <tr style="line-height:10rem;">
                                <td class="w-25"><img style="width:50%;" src="<?= $product[0]->image?>"></td>
                                <td class="text-info">
                                    <b style="text-shadow: 0.5px 0.5px 0.1rem white;"><?= $product[0]->name?></b>
                                </td>
                                <td class="text-center">
                                    <?= $row->quantity?>
                                </td>
                                <td><?= number_format($product[0]->price, 0, ",", ".")?>đ</td>
                            </tr>
                    <?php endforeach?>
                    <tr>
                        <td colspan="3"><b>TOTAL</b></td>
                        <td colspan="2">
                            <?php
                                $sum = 0;
                                foreach($bDArray as $row)
                                {
                                    $pro = new Product();
                                    $pro->proID = $row->proID;
                                    $product = $pro->getAProductByID($con);
                                    $sum += ($row->quantity * $product[0]->price);
                                }
                                echo number_format($sum, 0, ",", ".") ."đ"
                            ?>
                        </td>
                    </tr>
                </table>

                <div class="row w-100 mx-auto text-center">
                    <div class="col-md-12 mt-2">
                        <h3 class="text-info">
                            Tình trạng đơn hàng:
                            <?php
                                if($bill->billStatus == 0)
                                    echo "Chờ giao hàng";
                                else
                                    echo "Đã giao hàng";
                            ?>
                        </h3>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
</div>

<?php include "./Layout/footer.php" ?>