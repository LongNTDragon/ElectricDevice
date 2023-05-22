<?php
    require "../Class/Database.php";
    require "./autoload.php";
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

    if(!isset($_GET['proid']))
        header("location:product.php?catID=1");
        
    $con = Database::connectDB();
    $id = $_GET['proid'];
    $product = new Product();
    $product->proID = $id;
    $pro = $product->getAProductByID($con);

    if(!isset($pro))
        echo '<script>alert("ID không hợp lệ.");
        window.location.href="product.php?catID=1"; </script>';

    $categories = new Categories();
    $dataCat = $categories->getAllCategories($con);
?>

<?php
    $name = $pro[0]->name; 
    $price = $pro[0]->price;
    $status = $pro[0]->status;
    $typePro = $pro[0]->catID;
    $insurance = $pro[0]->insurance;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $typePro = $_POST['catID'];
        $insurance = $_POST['insurance'];

        $p = new Product();
        $p->proID = $pro[0]->proID;
        $p->name = $name;
        $p->price = $price;
        $p->status = $status;
        $p->insurance = $insurance;
        $p->catID = $typePro;

        $p->updateProduct($con);
        header("location:detail.php?proid=".$id);
    }
?>

<?php require "./Layout/header.php"?>
<title>Update Product</title>

<?php require "./menu.php"?>

<div class="row container-fluid" style="margin-top: 5rem;">
    <div class="col-md-3 col-sm-1"></div>
    <div class="col-md-6 col-sm-10 mt-4 card">
        <div class="card-body">
            <h2 class="text-center">CẬP NHẬT SẢN PHẨM</h2>
  
            <form action="" method="post">                
                <div class="row w-75 mx-auto">
                    <div class="col-md-12 mt-3">
                        <label for="name">Tên sản phẩm</label>
                        <input class="form-control" name="name" id="name" value="<?=$name?>" type="text" placeholder="Tên sản phẩm" required>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3">
                    <div class="col-md-6">
                    <label for="price">Giá sản phẩm</label>
                        <input class="form-control" name="price" id="price" min="100000" value="<?=$price?>" type="number" placeholder="Giá sản phẩm" required>
                    </div>

                    <div class="col-md-6">
                        <label for="catID">Loại sản phẩm</label>
                        <select class="form-control" id="catID" name="catID" disabled>
                            <?php
                                foreach($dataCat as $cat):
                                    if($cat->catID == $typePro):
                            ?>
                                        <option value="<?=$cat->catID?>" selected><?=$cat->catName?></option>
                            <?php
                                    else:
                            ?>
                                        <option value="<?=$cat->catID?>"><?=$cat->catName?></option>
                            <?php
                                    endif;
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3">
                    <div class="col-md-6">
                        <label for="status">Tình trạng</label>
                        <input class="form-control" name="status" id="status" value="<?=$status?>" type="text" placeholder="Tình trạng sản phẩm" required>
                    </div>

                    <div class="col-md-6">
                        <label for="insurance">Thời gian bảo hành</label>
                        <input class="form-control" name="insurance" id="insurance" min="1" value="<?=$insurance?>" type="number" placeholder="Thời gian bảo hành" required>
                    </div>
                </div>

                <div class="row w-75 mx-auto p-2 text-center mt-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><input type="submit" id="submit" name="submit" class="form-control btn btn-outline-secondary" value="CẬP NHẬT" /></div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require "./Layout/footer.php" ?>