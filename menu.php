  <?php 
    require "./CSS/menu_css.php";
  ?>
  
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">
            <img src="./Image/logoMain.png" alt="Logo" width="110" height="50" class="d-inline-block align-text-top">
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a href="index.php" class="nav-link">TRANG CHỦ</a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                      SẢN PHẨM
                  </a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product.php?catID=1">PC</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=2">Laptop</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=3">Chuột</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=4">Màn hình</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=5">Bàn phím</a></li>
                  </ul>
              </li>
              <li class="nav-item">
                  <a href="contact.php" class="nav-link">LIÊN HỆ</a>
              </li>
              <?php
                    if(isset($_SESSION['user'])):
                  ?>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                          TÀI KHOẢN
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="infoUser.php">CẬP NHẬT</a></li>
                            <li><a class="dropdown-item" href="changePass.php">ĐỔI MẬT KHẨU</a></li>
                        </ul>
                      </li>
                      <li class="nav-item">
                        <a href="billInfo.php" class="nav-link">ĐƠN HÀNG</a>
                      </li>
                  <?php endif;?>
            </ul>

            <form action="productFind.php" method="post" class="d-flex w-25" style="float: left;">
              <input id="search" name="search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn_search" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </form>

            <div class="text-dark text-center dropdown" id="log_reg">
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-user"></i>
                </a>
                <ul class="dropdown-menu">
                  <?php
                    if(!isset($_SESSION['user'])):
                  ?>
                      <li><a class="dropdown-item" href="login.php">Đăng nhập</a></li>
                      <li><a class="dropdown-item" href="register.php">Đăng ký</a></li>
                  <?php else :?>
                      <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                  <?php endif;?>
                </ul>
                <div class="text-dark text-center mt-3" id="shopCart">
                  <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                  <div class="amount">
                      <div>
                        <?php
                        $count = 0;
                        if(isset($_SESSION['user']))
                        {
                          $cart = new Cart();
                          $cart->userID = $_SESSION['user'][0]->userID;
                          $count = $cart->countProductInCart($con);
                        }
                          if($count < 10):
                        ?>
                            <small style="right:0.3rem;"><?=$count?></small>
                        <?php else:?>
                            <small style="right:0.1rem;">$count</small>
                        <?php endif;?>
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </nav>