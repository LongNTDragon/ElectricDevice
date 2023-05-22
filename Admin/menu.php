  <?php 
    require "../CSS/menu_css.php";
  ?>
  
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark fixed-top bg-black">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">
            <img src="../Image/logoMain.png" alt="Logo" width="110" height="50" class="d-inline-block align-text-top">
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
                      NGƯỜI DÙNG
                  </a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="users.php">Danh sách người dùng</a></li>
                      <li><a class="dropdown-item" href="new_user.php">Thêm người dùng</a></li>
                  </ul>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                      SẢN PHẨM
                  </a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="new_product.php">Thêm sản phẩm</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=1">PC</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=2">Laptop</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=3">Chuột</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=4">Màn hình</a></li>
                      <li><a class="dropdown-item" href="product.php?catID=5">Bàn phím</a></li>
                  </ul>
              </li>
              <li class="nav-item">
                <a href="bill.php" class="nav-link">ĐƠN HÀNG</a>
              </li>
            </ul>

            <form class="d-flex w-25" style="float: left;">
              <input id="search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn_search" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </form>

            <div class="text-dark text-center dropdown" id="log_reg">
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-user"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="../logout.php">Đăng xuất</a></li>
                </ul>
            </div>
          </div>
        </div>
    </nav>