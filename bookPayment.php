<?php
include("auth.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusantara Trip</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./Style/card.css">
    <link rel="stylesheet" href="./Style/navbar.css">
    <link rel="stylesheet" href="./Style/custome.css">
    <link rel="stylesheet" href="./Style/detail.css">
    <!-- ICON HEADER -->
    <link rel="icon" href="./Assets/tour (1).png">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <!-- ICON -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>
    <h2 class="pay-title">Nusantara<span>Trip</span></h2>
    <div class="pay-line"></div>
    <div class="pay-process">
        <div class="pay-processLeft"><i class='bx bx-check'></i></div>
        <div class="pay-processLine"></div>
        <div class="pay-processLeft"><i class='bx bx-check'></i></div>
        <div class="pay-processLine"></div>
        <div class="pay-processLeft"><i class='bx bx-check'></i></div>
        <div class="pay-processLine"></div>
        <div class="pay-processRight">4</div>
    </div>
    <div class="pay-titleBar">
        <h2>Payment Details</h2>
        <p>Kindly follow the detail payment below</p>
    </div>
    <?php
    $data = mysqli_query($connect, "SELECT * FROM users, booking WHERE booking.id_login=users.id_login AND users.username='$_SESSION[username]' ORDER BY booking.id DESC LIMIT 1");
    $a = 1;
    $result = mysqli_fetch_array($data);
    ?>
    <div class="pay-detail">
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <h4>Transfer Pembayaran : </h4>
                <p><?= $result['nama'] ?></p>
            </div>
        </div>
        <div class="pay-details">
            <div class="pay-line"></div>
        </div>
        <div class="pay-details d-flex mt-1">
            <div class="pay-desc">
                <h4>Jumlah total Pembayaran</h4>
            </div>
            <div class="pay-desc">
                <h4>Rp. <?= $result['price'] ?></h4>
            </div>
        </div>
        <div class="pay-details">
            <div class="pay-line"></div>
        </div>
        <div class="pay-details d-flex mt-1">
            <div class="pay-desc">
                <h4>Transfer Melalui : </h4>
            </div>
        </div>
        <div class="pay-details d-flex mt-1">
            <div class="pay-desc">
                <img src="./Assets/dana.png" alt="">
            </div>
            <div class="pay-desc">
                <h4>E-Wallet Dana</h4>
                <p>0895123456</p>
                <p>MUHAMMAD RIZKI WAHYUDIE</p>
            </div>
        </div>
        <div class="pay-details d-flex mt-1">
            <div class="pay-desc">
                <img src="./Assets/bni.png" alt="">
            </div>
            <div class="pay-desc">
                <h4>Bank BNI</h4>
                <p>1060371234</p>
                <p>MUHAMMAD RIZKI WAHYUDIE</p>
            </div>
        </div>
        <center>
            <div class="pay-btn">
                <a href="bookSuccess.php">Payment Successful</a>
            </div>
            <div class="pay-wa">
                <a href="bookPayment.php" target="_blank">Confirm via whatsapp</a>
            </div>
        </center>
    </div>
</body>

</html>