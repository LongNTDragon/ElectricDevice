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

    $con = Database::connectDB();
?>

<?php
    $name = ""; $price = "";
    $status = "";
    $imageErr = ""; $image = "";
    $typePro = "";
    $insurance = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $status = $_POST['status'];
        $typePro = $_POST['catID'];
        $insurance = $_POST['insurance'];

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
                $i = count($p->getAllNewProductByCatID($con));

                $dest = "." . $str . $fname . "$i" . '.' . $extension;
            }
    
            if($dest == null)
                throw new Exception("File is require !");

            if(move_uploaded_file($_FILES['uploadImg']['tmp_name'], $dest) && empty($typeProErr))
            {
                $pro = new Product();
                $pro->name = $name;
                $pro->price = $price;
                $pro->image = substr($dest, 1);
                $pro->status = $status;
                $pro->insurance = $insurance;
                $pro->catID = $typePro;

                $id = $pro->insertProduct($con);
                if($id != 0)
                    header("location:detail.php?proid=".$id);
            }
        }
        catch(Exception $e)
        {
            $imageErr = $e->getMessage();
        }
    }
?>

<?php require "./Layout/header.php"?>
<title>New Product</title>

<?php require "./menu.php"?>

<div class="row container-fluid" style="margin-top: 5rem;">
    <div class="col-md-3 col-sm-1"></div>
    <div class="col-md-6 col-sm-10 mt-4 card">
        <div class="card-body">
            <h2 class="text-center">THÊM SẢN PHẨM</h2>
  
            <form action="" method="post" enctype="multipart/form-data">                
                <div class="row w-75 mx-auto">
                    <div class="col-md-12 mt-3">
                        <input class="form-control" name="name" id="name" value="<?=$name?>" type="text" placeholder="Tên sản phẩm" required>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3">
                    <div class="col-md-6">
                        <input class="form-control" name="price" id="price" min="100000" value="<?=$price?>" type="number" placeholder="Giá sản phẩm" required>
                    </div>

                    <div class="col-md-6">
                        <select class="form-control" id="catID" name="catID" required>
                            <option value="">Loại sản phẩm</option>
                            <option value="1">PC</option>
                            <option value="2">Laptop</option>
                            <option value="3">Chuột</option>
                            <option value="4">Màn hình</option>
                            <option value="5">Bàn phím</option>
                        </select>
                    </div>
                </div>

                <div class="row w-75 mx-auto mt-3">
                    <div class="col-md-6">
                        <input class="form-control" name="status" id="status" value="<?=$status?>" type="text" placeholder="Tình trạng sản phẩm" required>
                    </div>

                    <div class="col-md-6">
                        <input class="form-control" name="insurance" id="insurance" min="1" value="<?=$insurance?>" type="number" placeholder="Thời gian bảo hành" required>
                    </div>
                </div>

                <div class="row w-75 mx-auto p-2 text-center mt-3">
                    <div class="col-md-12">
                        <input class="form-control" id="uploadImg" name="uploadImg" type="file" value="True" required />
                        <span style="color:red;"><?= $imageErr?></span>
                    </div>
                </div>

                <div class="row w-75 mx-auto p-2 text-center mt-3">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"><input type="submit" id="submit" name="submit" class="form-control btn btn-outline-secondary" value="THÊM" /></div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require "./Layout/footer.php" ?>