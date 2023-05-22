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
    $b = new BillDetail();

    if(!isset($_GET['billID']))
        header("location:bill.php");
    $b->billID = $_GET['billID'];
    
    $billArr = $b->getAllProductByID($con);
    if(empty($billArr))
        header("location:bill.php");
?>

<?php require "./Layout/header.php"?>
<title>Bill Detail</title>

<?php require "../CSS/cart_css.php"?>
<?php require "./menu.php"?>

<div class="text-white container-fluid" style="margin-top: 5rem;">
    
    <div class="row w-100 mx-auto text-center">
        <div class="col-md-12 mt-2">
            <h3 class="text-info">Số HD: <?php echo $billArr[0]->billID;?></h3>
        </div>
    </div>
    <table class="table text-center table-bordered">
        <tr>
            <th>Sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
        </tr>
        <?php
            foreach($billArr as $bill):
                $pro = new Product();
                $pro->proID = $bill->proID;
                $product = $pro->getAProductByID($con);
        ?>
        
                <tr style="line-height:10rem;">
                    <td class="w-25"><img style="width:50%;" src=".<?= $product[0]->image?>"></td>
                    <td class="text-info">
                        <b style="text-shadow: 0.5px 0.5px 0.1rem white;"><?= $product[0]->name?></b>
                    </td>
                    <td class="text-center">
                        <?= $bill->quantity?>
                    </td>
                    <td><?= number_format($product[0]->price, 0, ",", ".")?>đ</td>
                </tr>
        <?php endforeach?>
        <tr>
            <td colspan="3"><b>TOTAL</b></td>
            <td colspan="1">
                <?php
                    $sum = 0;
                    foreach($billArr as $bill)
                    {
                        $pro = new Product();
                        $pro->proID = $bill->proID;
                        $product = $pro->getAProductByID($con);
                        $sum += ($bill->quantity * $product[0]->price);
                    }
                    echo number_format($sum, 0, ",", ".") ."đ"
                ?>
            </td>
        </tr>
    </table>
</div>

<?php include "./Layout/footer.php" ?>