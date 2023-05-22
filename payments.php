<?php
    require "config.php";
    require "autoload.php";
    session_start();

    if(!isset($_SESSION['user']))
    {
        echo "<script>alert('Bạn chưa đăng nhập.');
        window.location.href='login.php'</script>";
    }

    $con = Database::connectDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>

<?php
    $fullname = $_SESSION['user'][0]->fullname ?? ""; 
    $phone = $_SESSION['user'][0]->phone ?? "";
    $email = $_SESSION['user'][0]->email; 
    $emailError = ""; $cssEmailError = "";
    $address = $_SESSION['user'][0]->address ?? "";

    if(isset($_POST['submit']))
    {
        $fullname = $_POST["fullname"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];

        $u = new User();
        $u->userID = $_SESSION['user'][0]->userID;
        $u->fullname = $fullname;
        $u->phone = $phone;
        $u->email = $email;
        $u->address = $address;
        if($_SESSION['user'][0]->email != $u->email)
        {
            if(!empty($u->chk_Email($con)))
            {
                $emailError = '<i class="fa-solid fa-triangle-exclamation"></i> Email already exists.'; 
                $cssEmailError = "box-shadow: 0 0 0.5rem red";
            }
        }
        else
        {
            $u->updateCus($con);

            $b = new Bill();
            $b->userID = $_SESSION['user'][0]->userID;
            $bID = $b->createBill($con);

            $c = new Cart();
            $c->userID = $_SESSION['user'][0]->userID;
            $cartArr = $c->getAllProductOfUser($con);

            if($bID != 0)
            {
                $sumMoney = 0;
                foreach($cartArr as $cart)
                {
                    $bD = new BillDetail();
                    $bD->billID = $bID;
                    $bD->proID = $cart->proID;

                    $p = new Product();
                    $p->proID = $cart->proID;
                    $pro = $p->getAProductByID($con);

                    $bD->price = $pro[0]->price;
                    $bD->quantity = $cart->quantity;

                    $sumMoney += ($pro[0]->price * $cart->quantity);
                    $bD->addProduct($con);
                }

                $b = new Bill();
                $b->billID = $bID;
                $b->sumMoney = $sumMoney;
                $b->updateSumMoney($con);

                echo "<script>alert('Đặt hàng thành công.');
                    window.location.href='billInfo.php'</script>";
            }
        }
    }
?>
<?php require "./Layout/header.php"?>
<title>Customer</title>
<?php require "./CSS/register_css.php"?>

<?php require "./menu.php"?>

    <div class="row container-fluid" style="margin-top: 5rem;">
        <div class="col-md-3 col-sm-1"></div>
        <div class="col-md-6 col-sm-10 mt-4 card">
          <div class="card-body">
            <h2 class="text-center text-white">THÔNG TIN GIAO HÀNG</h2>
    
            <form action="payments.php" method="post">                
                <div class="row m-1 mt-3">
                    <div class="col-md-6">
                        <input class="form-control" id="fullname" name="fullname" placeholder="Họ và tên" type="text" value="<?= $fullname?>" required/>
                    </div>
                    
                    <div class="col-md-6 mt-md-0 mt-4">
                        <input class="form-control" id="phone" name="phone" minlength="10" maxlength="10" placeholder="Số điện thoại" type="text" value="<?= $phone?>" required/>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-12">
                        <input style="<?= $cssEmailError?>" class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?= $email?>" required/>
                        <span style="color:yellow;"><?= $emailError?></span>
                    </div>
                </div>

                <div class="row m-1 mt-4">
                    <div class="col-md-3">
                        <input class="form-control" id="housenumber" name="housenumber" maxlength="8" placeholder="Số nhà" type="number" required/>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" id="city" required>
                            <option value="" selected>Chọn tỉnh / thành</option>           
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" id="district" required>
                            <option value="" selected>Chọn quận / huyện</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" id="ward" required>
                            <option value="" selected>Chọn phường / xã</option>
                        </select>
                    </div>
                    <input type="hidden" id="address" name="address" value="">
                </div>

                <div class="row w-75 mx-auto mt-3 mb-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-6"><input type="submit" id="submit" name="submit" class="form-control" value="HOÀN TẤT ĐƠN HÀNG" style="width: 100%; margin-top: 0.5rem;" /></div>
                </div>
            </form>
          </div>
        </div>
    </div>

<?php require "./Layout/footer.php" ?>

<script>
    const host = "https://provinces.open-api.vn/api/";
    var callAPI = (api) => {
        return axios.get(api).then((response) => {
            renderData(response.data, "city");
        });
    }

    callAPI('https://provinces.open-api.vn/api/?depth=1');
    var callApiDistrict = (api) => {
        return axios.get(api).then((response) => {
            renderData(response.data.districts, "district");
        });
    }

    var callApiWard = (api) => {
        return axios.get(api).then((response) => {
            renderData(response.data.wards, "ward");
        });
    }

    var renderData = (array, select) => {
        let row = ' <option disable value="">Chọn</option>';
        array.forEach(element => {
            row += `<option data-id="${element.code}" value="${element.name}">${element.name}</option>`
        });
        document.querySelector("#" + select).innerHTML = row
    }

    $("#city").change(() => {
        callApiDistrict(host + "p/" + $("#city").find(':selected').data('id') + "?depth=2");
    });

    $("#district").change(() => {
        callApiWard(host + "d/" + $("#district").find(':selected').data('id') + "?depth=2");
    });

    $("#ward").change(() => {
        printResult();
    })

    var printResult = () => {
        if ($("#district").find(':selected').data('id') != "" && $("#city").find(':selected').data('id') != "" && $("#ward").find(':selected').data('id') != "") {
            let result = $("#housenumber").val() + ", " + $("#ward option:selected").text() +
                ", " + $("#district option:selected").text() + ", " +
                $("#city option:selected").text()
            $("#address").val(result);
        }
    }
</script>