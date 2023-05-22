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
?>

<?php
    $imageErr = ""; $image = "";
    $typePro = $pro[0]->catID;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        try
        {
            if($_FILES['uploadImg']['error'] == UPLOAD_ERR_NO_FILE)
                $dest = null;
            else
            {
                if($_FILES['uploadImg']['size'] > 10000000)
                throw new Exception("File too large.");

                $mime_types = ['image/gif', 'image/jpeg', 'image/png'];
                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($file_info, $_FILES['uploadImg']['tmp_name']);
        
                if(!in_array($mime_type, $mime_types))
                    throw new Exception("Invalid file type.");

                $path = pathinfo($_FILES['uploadImg']['name']);
                $extension = $path['extension'];
    
                if($typePro == 1)
                {
                    $str = './Image/PC/';
                    $fname = 'PC';
                }
                if($typePro == 2)
                {
                    $str = './Image/LapTop/';
                    $fname = 'LAP';
                }
                if($typePro == 3)
                {
                    $str = './Image/Chuot/';
                    $fname = 'CH';
                }
                if($typePro == 4)
                {
                    $str = './Image/ManHinh/';
                    $fname = 'MH';
                }
                if($typePro == 5)
                {
                    $str = './Image/BanPhim/';
                    $fname = 'BP';
                }
                
                $p = new Product();
                $p->catID = $typePro;
                $i = count($p->getAll($con));

                $dest = "." . $str . $fname . "$i" . '.' . $extension;
                while(file_exists($dest))
                {
                    $i++;
                    $dest = "." . $str . $fname . "$i" . '.' . $extension;
                }
            }

            if(move_uploaded_file($_FILES['uploadImg']['tmp_name'], $dest))
            {
                $src = "." . $pro[0]->image;
                unlink($src);

                $p = new Product();
                $p->proID = $pro[0]->proID;
                $p->image = substr($dest, 1);
                $p->updateProImg($con);
                header("location:detail.php?proid=". $pro[0]->proID);
            }
        }
        catch(Exception $e)
        {
            $imageErr = $e->getMessage();
        }
    }
?>

<?php require "./Layout/header.php"?>
<title>Update Product Image</title>

<?php require "./menu.php"?>

<div class="row container-fluid" style="margin-top: 5rem;">
    <div class="col-md-3 col-sm-1"></div>
    <div class="col-md-6 col-sm-10 mt-4 card">
        <div class="card-body">
            <h2 class="text-center">CẬP NHẬT HÌNH ẢNH</h2>
  
            <form action="" method="post" enctype="multipart/form-data">                
                <div class="row w-75 mx-auto text-center">
                    <div class="col-md-4 mt-3">
                        <label for="oldImg">Ảnh hiện tại</label>
                        <img class="w-100" src=".<?= $pro[0]->image?>" alt="">
                    </div>
                    <div class="col-md-8 mt-3">
                        <label for="newImg">Ảnh mới</label>
                        <input class="form-control mt-5" id="uploadImg" name="uploadImg" type="file" value="True" required/>
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