<?php
include("auth.php");
if (isset($_GET['id_hotel'])) {
    $id = $_GET['id_hotel'];
} else {
    die("Error. No ID Selected!");
}
$query    = mysqli_query($connect, "SELECT * FROM hotel WHERE id_hotel='$id'");
$result    = mysqli_fetch_array($query);
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
    <section>
        <!-- BREADCRUMB -->
        <div class="breadcrumb">
            <a href="formBooking.php" class="breadcrumb-home">Home / </a><span class="breadcrumb-popular"> Detail</span>
        </div>
        <center>
            <div class="detail-title">
                <h1><?php echo $result['namaHotel'] ?></h1>
                <span><?php echo $result['alamatHotel'] ?></span>
            </div>
        </center>
        <div class="container">
            <div class="detail-flex">
                <div class="detail-left">
                    <img src="Assets/<?php echo $result['pictOne'] ?>" alt="">
                </div>
                <div class="detail-right">
                    <img src="Assets/<?php echo $result['pictTwo'] ?>" alt="">
                    <img class="mt-1" src="Assets/<?php echo $result['pictThree'] ?>" alt="">
                </div>
            </div>
            <div class="detail-flex">
                <div class="detail-desc">
                    <h2>About the Place</h2>
                    <span>
                        <?php echo $result['descHotel'] ?>
                    </span>
                    <div class="detail-fasilitas">
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-1.png" alt="">
                            <p><?php echo $result['bedroom'] ?> <span>Bedroom</span></p>
                        </div>
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-2.png" alt="">
                            <p><?php echo $result['livingroom'] ?> <span>Living Room</span></p>
                        </div>
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-3.png" alt="">
                            <p><?php echo $result['breakfast'] ?> <span>Breakfast</span></p>
                        </div>
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-4.png" alt="">
                            <p><?php echo $result['bathup'] ?> <span>BathUp</span></p>
                        </div>
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-5.png" alt="">
                            <p><?php echo $result['speedWifi'] ?> <span>mbp/s</span></p>
                        </div>
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-6.png" alt="">
                            <p><?php echo $result['ac'] ?> <span>Air Conditioner</span></p>
                        </div>
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-7.png" alt="">
                            <p><?php echo $result['refrigerator'] ?> <span>Refrigerator</span></p>
                        </div>
                        <div>
                            <img src="https://admin-bwamern.herokuapp.com/images/feature-8.png" alt="">
                            <p><?php echo $result['tv'] ?> <span>Television</span></p>
                        </div>
                    </div>
                    <iframe src="<?php echo $result['maps'] ?>" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="detail-price">
                    <form action="prosesBooking.php" method="POST">
                        <h2>Start Booking</h2>
                        <input name="id_hotel" type="hidden" value="<?php echo $result['id_hotel'] ?>">
                        <div class="my-1">
                            <label>Hotel</label>
                            <input required name="hotel" style="text-transform: uppercase;" type="text" value="<?php echo $result['namaHotel'] ?>">
                        </div>
                        <div class="detail-form my-1">
                            <div>
                                <label class="mr-1">Name</label>
                                <input required class="mr-1" name="nama" type="text" placeholder="Enter Your Name">
                            </div>
                            <div class="sm-my-1">
                                <label class="ml-1">Phone</label>
                                <input required class="ml-1" name="phone" type="text" placeholder="Enter Your Phone">
                            </div>
                        </div>
                        <div class="my-1">
                            <label>Room Type</label>
                            <select name="room_type">
                                <option value="1">Private Room (1 to 2 people) Rp. <?= $result['priceTypeOne'] ?></option>
                                <option value="2">Deluxe Room (3 to 6 people) Rp. <?= $result['priceTypeTwo'] ?></option>
                                <option value="3">Party Room (Up to 7 people) Rp. <?= $result['priceTypeThree'] ?></option>
                            </select>
                        </div>
                        <div class="my-1">
                            <label>Number of Guests</label>
                            <select name="tamu">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        <div class="detail-form my-1">
                            <div>
                                <label class="mr-1">Arrival Date</label>
                                <input required class="mr-1" name="arrived" type="date">
                            </div>
                            <div class="sm-my-1">
                                <label class="ml-1">Departure Date</label>
                                <input required class="ml-1" name="departure" type="date">
                            </div>
                        </div>
                        <input class="submit" type="submit" value="Continue to Book" name="book" />
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>