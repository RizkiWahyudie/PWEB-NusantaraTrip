<?php
include("auth.php");

if (isset($_GET['id'])) {
    // ambil id dari query string
    $id = $_GET['id'];
} else {
    die("akses dilarang...");
}

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
    <!-- <div class="pay-process">
        <div class="pay-processLeft"><i class='bx bx-check'></i></div>
        <div class="pay-processLine"></div>
        <div class="pay-processLeft"><i class='bx bx-check'></i></div>
        <div class="pay-processLine"></div>
        <div class="pay-processRight">3</div>
        <div class="pay-processLine"></div>
        <div class="pay-processRight">4</div>
    </div> -->
    <div class="pay-titleBar">
        <h2>Book Details</h2>
        <p>Kindly follow the detail book below</p>
    </div>
    <?php
    $sql = "CALL detailBookingAll('$_SESSION[username]', $id)";
    $data = mysqli_query($connect, $sql);
    $result = mysqli_fetch_array($data);
    ?>
    <div class="pay-detail">
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <h4>ID Pemesanan</h4>
                <p><?= $result['id'] ?></p>
            </div>
            <div class="pay-desc">
                <h4>Status</h4>
                <p class="pay-confirm">🟢 Terkonfirmasi</p>
            </div>
        </div>
        <h4 class="pay-rinci pay-details">Data Tamu</h4>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Nama Tamu</p>
            </div>
            <div class="pay-desc">
                <p><?= $result['nama'] ?></p>
            </div>
        </div>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Telepone (Whatsapp)</p>
            </div>
            <div class="pay-desc">
                <p><?= $result['phone'] ?></p>
            </div>
        </div>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Email</p>
            </div>
            <div class="pay-desc">
                <p><?= $result['email'] ?></p>
            </div>
        </div>
        <h4 class="pay-rinci pay-details">Rincian Pemesanan</h4>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Nama Hotel</p>
            </div>
            <div class="pay-desc">
                <p><?= $result['hotel'] ?></p>
            </div>
        </div>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Type Room</p>
            </div>
            <div class="pay-desc">
                <p><?= $result['room_type'] ?></p>
            </div>
        </div>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Jumlah Kamar</p>
            </div>
            <div class="pay-desc">
                <p>1 (<?= $result['tamu'] ?> Tamu)</p>
            </div>
        </div>
        <div class="pay-details d-flex">
            <div class="pay-desc pay-checkin">
                <h4>Checkin</h4>
                <p><?= $result['arrived'] ?></p>
            </div>
            <div class="pay-desc">
                <h4 class="mt-2"><?= $result['jml_malam'] ?> malam</h4>
            </div>
            <div class="pay-desc pay-checkin">
                <h4>Checkout</h4>
                <p><?= $result['departure'] ?></p>
            </div>
        </div>
        <div class="pay-details">
            <div class="pay-line mt-1"></div>
        </div>
        <h4 class="pay-rinci pay-details">Detail Harga</h4>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Tipe Ruangan</p>
            </div>
            <div class="pay-desc">
                <p><?= $result['room_type'] ?></p>
            </div>
        </div>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Jumlah Malam</p>
            </div>
            <div class="pay-desc">
                <p><?= $result['jml_malam'] ?></p>
            </div>
        </div>
        <div class="pay-details d-flex">
            <div class="pay-desc">
                <p>Jumlah Kamar</p>
            </div>
            <div class="pay-desc">
                <p>1 (<?= $result['tamu'] ?> Tamu)</p>
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
    </div>
</body>

</html>