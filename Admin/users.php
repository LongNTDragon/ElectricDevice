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

    $u = new User();
    $data = $u->getAllUser($con);
?>

<?php require "./Layout/header.php"?>
<title>Users</title>

<?php require "../CSS/product_css.php"?>
<?php require "./menu.php"?>

<div style="margin-top:5rem;" class="text-center">
    <h2>DANH SÁCH NGƯỜI DÙNG</h2>
</div>
    
    <table class="table table-secondary">
        <thead class="table-dark text-center">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th width="20px">Password</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
                if(!empty($data)):
                    foreach($data as $row):
            ?>
                        <tr class="table-group-divider" style="line-height:2rem;">
                            <td class="text-center"><?= $row->userID?></td>
                            <td class="text-center"><?= $row->username?></td>
                            <td class="text-center"><div style="width:100px; overflow:hidden; white-space:nowrap; text-overflow: ellipsis;"><?= $row->password?></div></td>
                            <td class="text-center"><?= $row->email?></td>
                            <td class="text-center">
                                <?php
                                    if($row->phone != null)
                                ?>
                                        <?= $row->phone?>
                            </td>
                            <td class="text-center">
                                <?php
                                    if($row->address != null)
                                ?>
                                        <?= $row->address?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    if($row->roleID == "1")
                                        echo "Admin";
                                    else
                                        echo "User";
                                ?>
                            </td>
                            <td style="width:10%;">
                                <a href="update_user.php?userID=<?= $row->userID?>" class="btn btn-outline-info">
                                    <i class="fa-solid fa-rotate"></i>
                                </a>
                                <i class="fa-regular fa-pipe" style="margin: 0 0.5rem;"></i>
                                <a href="remove_user.php?userID=<?= $row->userID?>" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
        </tbody>
    </table>

<?php include "./Layout/footer.php" ?>