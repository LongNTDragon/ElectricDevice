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

    $data = $product->getProductByPage($con, $limit, $offset, "");
?>

<?php require "./Layout/header.php"?>
<title>Products</title>

<?php require "../CSS/product_css.php"?>
<?php require "./menu.php"?>

<div style="margin-top:5rem;" class="text-center">
    <h2>DANH SÁCH SẢN PHẨM</h2>
</div>
    
    <table class="table table-secondary">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Insuarance</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
                if(!empty($data)):
                    foreach($data as $row):?>
                        <tr class="table-group-divider" style="line-height:2rem;">
                            <td class="text-center"><?= $row->proID?></td>
                            <td class="text-center"><a style="text-decoration:none;" href="detail.php?proid=<?= $row->proID ?>"><?= $row->name?></a></td>
                            <td class="text-center"><?= number_format($row->price, 0, ",", ".")?>đ</td>
                            <td class="text-center"><?= $row->status?></td>
                            <td class="text-center"><?= $row->insurance?></td>
                            <td class="text-center">
                                <?= $row->image?>
                                <a href="update_proimg.php?proid=<?= $row->proID?>" class="btn btn-outline-success">
                                    <i class="fa-solid fa-rotate"></i>
                                </a>
                            </td>
                            <td style="width:10%;">
                                <a href="update_product.php?proid=<?= $row->proID?>" class="btn btn-outline-info">
                                    <i class="fa-solid fa-rotate"></i>
                                </a>
                                <i class="fa-regular fa-pipe" style="margin: 0 0.5rem;"></i>
                                <a href="remove_product.php?proid=<?= $row->proID?>" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>

                    <tr>
                        <td colspan="7">
                            <ul class="pagination justify-content-center mb-0" style="--bs-pagination-color:black; --bs-pagination-active-bg: gray; --bs-pagination-active-border-color: #f8f9fa; --bs-pagination-focus-box-shadow: 0 0 0 0.2rem rgb(201, 197, 197, 0.3);">
                                <li class="page-item">
                                    <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $page-1?>">
                                        <i class="fa-duotone fa-backward"></i>
                                    </a>
                                </li>

                                <?php
                                    for($i = 1; $i <= $no_page; $i++):
                                        if($i == $page):
                                ?>
                                        <li class="page-item active">
                                            <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $i?>">
                                                <?= $i?>
                                            </a>
                                        </li>
                                    <?php else:?>
                                        <li class="page-item">
                                            <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $i?>">
                                            <?= $i?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                <?php endfor;?>

                                <li class="page-item active">
                                    <a class="page-link" href="product.php?catID=<?= $catID?>&page=<?= $page+1?>">
                                        <i class="fa-duotone fa-forward"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php endif;?>
        </tbody>
    </table>

<?php include "./Layout/footer.php" ?>