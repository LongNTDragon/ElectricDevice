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
?>

<?php require "./Layout/header.php"?>
<title>Home</title>

<?php require "../CSS/index_css.php"?>
<?php require "./menu.php"?>

<div class="text-center" style="margin-top:10rem; margin-bottom:4.75rem;">
    <h1 class="text-danger">Welcome to Admin Page</h1>
</div>

<?php include "./Layout/footer.php" ?>