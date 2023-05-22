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

    $b = new Bill();
    $data = $b->getAllBill($con);
?>

<?php require "./Layout/header.php"?>
<title>Bills</title>

<?php require "../CSS/product_css.php"?>
<?php require "./menu.php"?>

<div style="margin-top:5rem;" class="text-center">
    <h2>DANH SÁCH ĐƠN HÀNG</h2>
</div>
    
    <table class="table table-secondary">
        <thead class="table-dark text-center">
            <tr>
                <th>BillID</th>
                <th>UserID</th>
                <th>Created Date</th>
                <th>Received Date</th>
                <th>Sum Money</th>
                <th>Bill Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
                if(!empty($data)):
                    foreach($data as $row):
            ?>
                        <tr class="table-group-divider" style="line-height:2rem;">
                            <td class="text-center"><a style="text-decoration:none;" href="billdetail.php?billID=<?= $row->billID?>"><?= $row->billID?></a></td>
                            <td class="text-center"><a style="text-decoration:none;" href="userdetail.php?userID=<?= $row->userID?>"><?= $row->userID?></a></td>
                            <td class="text-center"><?= $row->createdDate?></td>
                            <td class="text-center">
                                <?php
                                    if($row->receivedDate != null)
                                ?>
                                        <?= $row->receivedDate?>
                            </td>
                            <td class="text-center"><?= $row->sumMoney?></td>
                            <td class="text-center">
                                <?php 
                                    if($row->billStatus == "0")
                                        echo "Chưa giao";
                                    else
                                        echo "Đã giao";
                                ?>
                            </td>
                            <td style="width:10%;">
                                <?php 
                                    if($row->billStatus == "0"):
                                ?>
                                        <a href="update_bill.php?billID=<?= $row->billID?>" class="btn btn-outline-info">
                                            <i class="fa-solid fa-rotate"></i>
                                        </a>
                                        <i class="fa-regular fa-pipe" style="margin: 0 0.5rem;"></i>
                                        <a href="remove_bill.php?billID=<?= $row->billID?>" class="btn btn-outline-danger">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                <?php 
                                    else:
                                ?>
                                        <a href="remove_bill.php?billID=<?= $row->billID?>" class="btn btn-outline-danger">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                <?php 
                                    endif;
                                ?>
                            </td>
                        </tr>
                    <?php endforeach?>
                <?php endif;?>
        </tbody>
    </table>

<?php include "./Layout/footer.php" ?>