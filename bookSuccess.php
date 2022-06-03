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
        <div class="pay-processLeft"><i class='bx bx-check'></i></div>
    </div>
    <div class="pay-titleBar">
        <h2>Yeay! Payment has been Completed</h2>
    </div>
    <?php
    $data = mysqli_query($connect, "SELECT * FROM users, booking WHERE booking.id_login=users.id_login AND users.username='$_SESSION[username]' ORDER BY booking.id DESC LIMIT 1");
    $a = 1;
    $result = mysqli_fetch_array($data);
    ?>
    <center>
        <div class="pay-success">
            <img src="./Assets/payment-successful.png" alt="">
            <p>We will inform you via your whatsapp <br>later once the transaction has been accepted</p>
            <div class="pay-btn">
                <a href="formBooking.php">Dashboard</a>
            </div>
        </div>
    </center>
</body>

</html>