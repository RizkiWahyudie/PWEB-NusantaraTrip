<?php
include("auth.php");
$data = mysqli_query($connect, "SELECT * FROM users WHERE users.username='$_SESSION[username]'");
$callback = mysqli_fetch_array($data);
include("changePassword.php");

// PAYMENT EXCECUTION
$pay_error = "";
$sqlcredit = mysqli_query($connect, "SELECT * FROM transaksi WHERE nama='$_SESSION[username]'");
$credittable = mysqli_fetch_array($sqlcredit);

if (isset($_POST['creditsubmit'])) {
    // AMBIL DATA DARI VALUE PAYMENT
    $idcard = $_POST['idcard'];
    $pin = $_POST['pin'];
    $idbooking = $_POST['idbooking'];
    $namahotel = $_POST['namahotel'];
    $nominal = $_POST['nominal'];
    $creditsisa = $credittable['saldo'] - $nominal;

    if ($pin != $credittable['pin'] || $idcard != $credittable['nomor_kartu']) {
        $pay_error = "ID Card atau PIN tidak valid!";
    } else {
        if ($nominal < 50000) {
            $pay_error = "Pembayaran Minimal Rp.50.000";
        } else if ($creditsisa < 50000) {
            $pay_error = "Minimal sisa saldo anda adalah Rp. 50.0000";
        } else {
            $checkpayment = "CALL payment($idcard, $pin, $nominal, $idbooking, '$namahotel', @pesan)";
            $paymentstatus = mysqli_query($connect, $checkpayment);
            $pay_error = "Pembayaran Booking Hotel Berhasil!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusantara Trip</title>
    <!-- ICON HEADER -->
    <link rel="icon" href="./Assets/tour (1).png">
    <!-- ICONSCOUT -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- BOX ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="./Style/detail.css">
    <link rel="stylesheet" href="./Style/destination.css">
    <link rel="stylesheet" href="./Style/dashboard.css">
    <link rel="stylesheet" href="./Style/bootstrap.css">
    <!-- JQUERY -->
    <script src="./JS/jquery-3.5.1.js"></script>
    <script src="./JS/jquery-3.5.1.min.js"></script>
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
</head>

<body id="Hide_sidebar">
    <div id="mainContent">
        <section class="mainBody"></section>
        <div class="d-flex Main_bg" id="wrapper">
            <!-- Sidebar-->
            <div class="Parents_sidebar poppins-font" id="sidebar-wrapper">
                <div class="sidebar-heading d-flex justify-content-center align-items-center mb-3 Brand"><img src="./Assets/tour (1).png" class="Brand_img me-3" alt="">NusantaraTrip</div>
                <div class="d-flex align-items-center justify-content-center sidebarUser">
                    <div>
                        <img width="50px" src="./Assets/<?= $callback['photo'] ?>" alt="">
                    </div>
                    <div class="ms-2">
                        <span class="d-block fw-bold">Halo, <?= $callback['username'] ?></span>
                        <span class="sidebarProfile">How are you?👋🏻</span>
                    </div>
                </div>
                <ul class="list-group list-group-flush" id="myNav">
                    <a class="click_menu active List_item text-decoration-none my-2 px-3" id="dashboard"><i class="uil uil-estate nav_icon me-3"></i><span>Home</span></a>
                    <a class="click_menu List_item text-decoration-none my-2 px-3" id="coinInOut"><i class="uil uil-map nav_icon me-3"></i><span>Destination</span></a>
                    <a class="click_menu List_item text-decoration-none my-2 px-3" id="trade"><i class="uil uil-invoice nav_icon me-3"></i><span>History</span></a>
                    <a class="click_menu List_item text-decoration-none my-2 px-3" id="setting"><i class="uil uil-diary nav_icon me-3"></i><span>Booking Now!</span></a>
                    <a class="click_menu List_item text-decoration-none my-2 px-3" id="key"><i class="uil uil-user nav_icon me-3"></i><span>Profile</span></a>
                    <?php
                    if ($callback['admin'] != 0) {
                    ?>
                        <a class="click_menu List_item text-decoration-none my-2 px-3" id="admin"><i class="uil uil-user nav_icon me-3"></i><span>Admin</span></a>
                    <?php } ?>
                    <a class="click_menu List_item text-decoration-none my-2 px-3" href="signout.php"><i class="uil uil-signout nav_icon me-3"></i><span>Logout</span></a>
                </ul>
                <div class="Card">
                    <img class="Card_imgg" src="./Assets/phone.svg" alt="">
                    <P>Need Some Help?</P>
                    <a href="" class="Card_btn">CONTACT US</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div class="Parents_content" id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand">
                    <div class="container-fluid mt-md-4">
                        <i class="uil uil-bars Sidebar_toggle" id="sidebarToggle"></i>
                        <span class="Nav_title nav_home">Dashboard</span>
                        <span class="Nav_title d-none nav_coin">Destination</span>
                        <span class="Nav_title d-none nav_trade">Booking</span>
                        <span class="Nav_title d-none nav_setting">Form Booking</span>
                        <span class="Nav_title d-none nav_key">User Profile</span>
                        <span class="Nav_title d-none nav_admin">Admin Page</span>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="navbar-collapse collapse">
                                <div class="navbar-nav ms-auto me-3">
                                    <!-- <div class="d-flex flex-column">
                                    <span class="h5">Halo, <?= $callback['username'] ?></span>
                                    <span>Happy & enjoy your holiday!</span>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->

                <?php
                $booked = mysqli_query($connect, "SELECT * FROM users, booking, hotel WHERE booking.id_login=users.id_login AND users.username='$_SESSION[username]' AND hotel.id_hotel=booking.id_hotel ORDER BY booking.id DESC LIMIT 1");
                $result = mysqli_fetch_array($booked);
                ?>
                <!-- HOME -->
                <div class="homePage">
                    <div class="homeSide d-flex flex-column flex-md-row">
                        <div class="homeLeft">
                            <div class="container-fluid">
                                <!-- HOME EMPTY BOOKED -->
                                <?php
                                if ($result < 1) {
                                ?>
                                    <div class="d-flex homeEmpty text-white">
                                        <img class="homeBg homeBgOne" src="./Assets/Frame 2188.svg" alt="">
                                        <img class="homeBg homeBgTwo" src="./Assets/Frame 2187.svg" alt="">
                                        <div class="homeEmptyOne">
                                            <h1>Your Liked Travel</h1>
                                            <span>Book Your Hotel for the first Time!</span>
                                        </div>
                                        <div class="homeEmptyTwo">
                                            <img src="./Assets/Saly-2.svg" alt="">
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <!-- HOME LAST BOOKED -->
                                    <div class="d-flex homeBook align-items-center">
                                        <div class="homeImg me-md-2">
                                            <img src="./Assets/<?= $result['pictOne'] ?>" alt="">
                                        </div>
                                        <div class="homeDesc ms-md-1">
                                            <h4 class="poppins-font fw-bold"><?= $result['hotel'] ?></h4>
                                            <p><small><?= $result['alamatHotel'] ?></small></p>

                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <div>
                                                    <span class="d-block"><small><?= $result['tamu'] ?> Tamu, <?= $result['jml_malam'] ?> Malam | ID : <?= $result['id'] ?></small></span>
                                                    <span class="d-block text-black"><small><?= $result['room_type'] ?></small></span>
                                                    <span class="text-black"><small><?= $result['arrived'] ?> - <?= $result['departure'] ?></small></span>
                                                </div>
                                                <div>
                                                    <iframe class="rounded-3" src="<?= $result['maps'] ?>" frameborder="0"></iframe>
                                                </div>
                                            </div>
                                            <button class="w-100 btn text-white mt-2">LATEST BOOKING</button>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <!-- HOME PROMO -->
                                <div class="homee">
                                    <center>
                                        <span class="home_subtitlee d-block">Let's Started Destination!</span>
                                        <span class="home_titlee">Plan Your Vacation Now</span>
                                        <a class="click_book home_btnn" id="setting">Book Hotel <i class="uil uil-location-arrow"></i></a>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="homeRight">
                            <div class="container-fluid">
                                <!-- HOME PROFILE -->
                                <div class="homeProfile">
                                    <img class="homeBgProfile" src="./Assets/bgProfile.png" width="100%" alt="">
                                    <div class="homePP d-flex ms-3">
                                        <img width="25%" src="./Assets/<?= $callback['photo'] ?>" alt="">
                                        <span>@<?= $callback['username'] ?></span>
                                    </div>
                                    <div>
                                        <div class="homeInput">
                                            <span>Nama Lengkap</span>
                                            <input type="text" value="<?= $callback['name'] ?>">
                                        </div>
                                        <div class="homeInput">
                                            <span>Email</span>
                                            <input type="text" value="<?= $callback['email'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CREDIT CARD -->
                    <div class="container-fluid">
                        <div class="credit d-flex flex-column flex-lg-row mb-3 text-white align-items-center">
                            <?php
                            if ($credittable < 1) {
                            ?>
                                <div class="creditLeft">
                                    <div class="m-3">
                                        <div class="creditBg">
                                            <img src="./Assets/creditholder.svg" class="credit_holder" alt="">
                                            <img src="./Assets/visa.svg" class="credit_visa" alt="">
                                            <h2>**** **** ****</h2>
                                            <span class="creditsaldo">Anda belum membuat card, harap hubungi admin</span>
                                            <div class="creditName">
                                                <label class="d-block">Card Holder Name</label>
                                                <span class="d-block">*********</span>
                                            </div>
                                            <div class="creditPin">
                                                <label class="d-block">Pin</label>
                                                <span class="d-block">*****</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="creditRight">
                                    <div class="ms-3 ms-lg-0 mt-3 me-3 mb-3 ">
                                        <h3 class="text-center text-secondary fw-bold">Payment Booking</h3>
                                        <div class="d-flex flex-row flex-wrap">
                                            <div class="creditInput">
                                                <input type="text" placeholder="ID Card">
                                            </div>
                                            <div class="creditInput">
                                                <input type="password" placeholder="PIN">
                                            </div>
                                            <div class="creditInput">
                                                <input type="text" placeholder="ID Booking">
                                            </div>
                                            <div class="creditInput">
                                                <input type="text" placeholder="Name of hotel">
                                            </div>
                                            <div class="creditInput">
                                                <input type="text" placeholder="Nominal">
                                            </div>
                                            <div class="creditInput">
                                                <input class="btn btn-danger" type="button" value="Don't Have Card">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } else {
                                $credithasil = mysqli_query($connect, "SELECT * FROM transaksi WHERE nama='$_SESSION[username]'");
                                $creditresult = mysqli_fetch_array($credithasil);
                            ?>
                                <div class="creditLeft">
                                    <div class="m-3">
                                        <div class="creditBg">
                                            <img src="./Assets/creditholder.svg" class="credit_holder" alt="">
                                            <img src="./Assets/visa.svg" class="credit_visa" alt="">
                                            <h2><?= $creditresult['nomor_kartu'] ?></h2>
                                            <span class="creditsaldo">Saldo Rp. <?= $creditresult['saldo'] ?></span>
                                            <div class="creditName">
                                                <label class="d-block">Card Holder Name</label>
                                                <span class="d-block"><?= $creditresult['nama'] ?></span>
                                            </div>
                                            <div class="creditPin">
                                                <label class="d-block">Pin</label>
                                                <span class="d-block"><?= $creditresult['pin'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="creditRight">
                                    <div class="ms-3 ms-lg-0 mt-3 me-3 mb-3 ">
                                        <h3 class="text-center text-secondary fw-bold">Payment Booking</h3>
                                        <form action="" method="POST">
                                            <div class="d-flex flex-row flex-wrap">
                                                <div class="creditInput">
                                                    <input name="idcard" type="text" placeholder="ID Card" required>
                                                </div>
                                                <div class="creditInput">
                                                    <input name="pin" type="password" placeholder="PIN" required>
                                                </div>
                                                <div class="creditInput">
                                                    <input name="idbooking" type="text" placeholder="ID Booking" required>
                                                </div>
                                                <div class="creditInput">
                                                    <input name="namahotel" type="text" placeholder="Name of hotel" required>
                                                </div>
                                                <div class="creditInput">
                                                    <input name="nominal" type="text" placeholder="Nominal" required>
                                                </div>
                                                <div class="creditInput">
                                                    <input class="btn btn-danger" name="creditsubmit" type="submit" value="Bayar">
                                                </div>
                                            </div>
                                        </form>
                                        <?php if ($pay_error) { ?>
                                            <div style="color: red">
                                                <p><?php echo $pay_error ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>

                    <!-- HISTORY -->
                    </table>
                    <div class="container-fluid">
                        <div class="historydown">
                            <h5>History Booking</h5>
                            <div class="historyTable">
                                <?php
                                include('historyTable.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HISTORY PAGE -->
                <div class="tradePage d-none">
                    <div class="container-fluid">
                        <div class="historydown">
                            <!-- HISTORY -->
                            <h5>History Booking</h5>
                            <div class="historyTable">
                                <?php
                                include('historyTable.php');
                                ?>
                            </div>
                        </div>

                        <!-- HISTORY PEMBAYARAN -->
                        <div class="historydown">
                            <h5>History Transaksi</h5>
                            <div class="historyTable">
                                <div class="table-responsive mt-3">
                                    <table class="table header-fixed">
                                        <thead class="historyHead">
                                            <tr class="d-flex historyrow">
                                                <th class='tableId'>#ID</th>
                                                <th class='tableHotel'>Status</th>
                                                <th class='tableUser'>Username</th>
                                                <!-- <th>Phone</th> -->
                                                <th class='tableCard'>ID Card</th>
                                                <th class='tableBooking'>ID Book</th>
                                                <th class='tableNamaHotel'>Nama Hotel</th>
                                                <!-- <th class='tableDeparture'></th> -->
                                                <!-- <th>Jumlah Malam</th> -->
                                                <th class='tablePrice'>Nominal</th>
                                                <!-- <th>Email</th> -->
                                                <!-- <th>ID_Login</th> -->
                                                <th class='tableWaktu'>Waktu Transaksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $showbayar = mysqli_query($connect, "SELECT * FROM log_transaksi WHERE namauser='$_SESSION[username]' ORDER BY id_transaksi DESC LIMIT 1");
                                            $showtransaksi = mysqli_fetch_array($showbayar);
                                            $tampilbayar = mysqli_query($connect, "SELECT * FROM log_transaksi WHERE namauser='$_SESSION[username]' ORDER BY id_transaksi DESC");
                                            $tampiltransaksi = mysqli_fetch_array($tampilbayar);
                                            if ($tampiltransaksi < 1) {
                                                echo "
                                                    <td><div><center><img class='invisible' width='300px' src='./Assets/no-results.png' alt=''></center></div></td>
                                                    <td class='historyEmptyy'>
                                                        <div class='historyEmpty'>
                                                            <img class='' width='250px' src='./Assets/no-results.png' alt=''>
                                                            <p>Sorry! Data Empty</p>
                                                        </div>
                                                    </td>
                                                ";
                                            } else {
                                            ?>
                                                <tr>
                                                    <td class="tableId"><?= $showtransaksi['id_transaksi'] ?></td>
                                                    <td class="tableHotel"><?= $showtransaksi['status'] ?></td>
                                                    <td class="tableUser"><?= $showtransaksi['namauser'] ?></td>
                                                    <td class="tableCard"><?= $showtransaksi['nomorkartu'] ?></td>
                                                    <td class="tableBooking"><?= $showtransaksi['idbooking_transaksi'] ?></td>
                                                    <td class="tableNamaHotel"><?= $showtransaksi['namahotel_transaksi'] ?></td>
                                                    <td class="tablePrice">Rp. <?= $showtransaksi['nominal_transaksi'] ?></td>
                                                    <td class='tableWaktu'><?= $showtransaksi['waktu_transaksi'] ?></td>
                                                </tr>
                                            <?php
                                                while ($tampilbayarr = mysqli_fetch_array($tampilbayar)) {
                                                    echo "<tr>";
                                                    echo "<td class='tableId'>" . $tampilbayarr['id_transaksi'] . "</td>";
                                                    echo "<td class='tableHotel'>" . $tampilbayarr['status'] . "</td>";
                                                    echo "<td class='tableUser'>" . $tampilbayarr['namauser'] . "</td>";
                                                    echo "<td class='tableCard'>" . $tampilbayarr['nomorkartu'] . "</td>";
                                                    echo "<td class='tableBooking'>" . $tampilbayarr['idbooking_transaksi'] . "</td>";
                                                    echo "<td class='tableNamaHotel'>" . $tampilbayarr['namahotel_transaksi'] . "</td>";
                                                    echo "<td class='tablePrice'>Rp. " . $tampilbayarr['nominal_transaksi'] . "</td>";
                                                    echo "<td class='tableWaktu'>" . $tampilbayarr['waktu_transaksi'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORM BOOKING -->
                <div class="settingPage d-none">
                    <div class="container-fluid">
                        <div class="detail-book bg-white">
                            <form action="prosesForm.php" method="POST">
                                <div class="">
                                    <label>Hotel</label>
                                    <select name="hotel">
                                        <option value="1">Jiwa Jawa Bromo Hotel</option>
                                        <option value="2">Mercure Jakarta Hotel</option>
                                        <option value="3">Dedanau Hotel</option>
                                        <option value="4">Pesona Bamboe Hotel</option>
                                    </select>
                                </div>
                                <div class="detail-form">
                                    <div>
                                        <label class="mt-2">Name</label>
                                        <input required class="" name="nama" type="text" placeholder="Enter Your Name">
                                    </div>
                                    <div class="mt-2">
                                        <label class="">Phone</label>
                                        <input required class="" name="phone" type="text" placeholder="Enter Your Phone">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label>Room Type</label>
                                    <select name="room_type">
                                        <option value="1">Private Room (1 to 2 people)</option>
                                        <option value="2">Deluxe Room (3 to 6 people)</option>
                                        <option value="3">Party Room (Up to 7 people)</option>
                                    </select>
                                </div>
                                <div class="mt-2">
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
                                <div class="detail-form">
                                    <div>
                                        <label class="mt-2">Arrival Date</label>
                                        <input required class="" name="arrived" type="date">
                                    </div>
                                    <div class="mt-2">
                                        <label class="">Departure Date</label>
                                        <input required class="" name="departure" type="date">
                                    </div>
                                </div>
                                <input class="submit mt-4" type="submit" value="Continue to Book" name="book" />
                            </form>
                        </div>
                    </div>
                </div>

                <!-- FORM SHANGE PASSWORD -->
                <div class="mapKeyPage d-none">
                    <!-- USER PROFILE -->
                    <div class="container-fluid">
                        <div class="detail-book bg-white">
                            <form action="" method="POST">
                                <div class="">
                                    <label>Nama</label>
                                    <input class="" name="name" disabled value="<?= $callback['name'] ?>" type="text" placeholder="Enter Your Name">
                                </div>
                                <div class="detail-form">
                                    <div>
                                        <label class="mt-3">Username</label>
                                        <input disabled name="username" class="" value="<?= $callback['username'] ?>" type="text" placeholder="Enter Your Name">
                                    </div>
                                    <div class="mt-3">
                                        <label class="">Email</label>
                                        <input disabled name="email" class="" value="<?= $callback['email'] ?>" type="text" placeholder="Enter Your Phone">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label>Password</label>
                                    <input class="" name="op" type="password" placeholder="Enter Your Password">
                                </div>
                                <div class="detail-form">
                                    <div>
                                        <label class="mt-3">New Password</label>
                                        <input class="" name="np" type="password" placeholder="Enter Your Password">
                                    </div>
                                    <div class="mt-3">
                                        <label class="">Confirm New Password</label>
                                        <input class="" name="c_np" type="password" placeholder="Enter Your New Password again">
                                    </div>
                                </div>
                                <?php if ($err) { ?>
                                    <script>
                                        alert('<?php echo $err ?>')
                                    </script>
                                <?php } ?>
                                <input class="submit mt-4" type="submit" value="Change Password" name="change" />
                            </form>
                        </div>
                    </div>
                </div>

                <!-- DESTINATION -->
                <div class="coinPage d-none">
                    <div class="container-fluid">
                        <!-- HOME -->
                        <section id="home">
                            <div class="hero">
                                <center>
                                    <h3 class="home_subtitle">Let's Started Destination!</h3>
                                    <span class="home_title">Explore Beatiful Places</span>
                                    <a class="home_btn" href="#destinasi">Get Started <i class="uil uil-location-arrow"></i></a>
                                </center>
                            </div>
                        </section>

                        <!-- POPULAR SEARCH -->
                        <section id="popular">
                            <div class="popular">
                                <center>
                                    <span class="covid_subtitle">User are looking for this explore</span>
                                    <span class="popular_title">Popular Search</span>
                                </center>
                                <div class="popular_search">
                                    <a href="/PopularPage/popular.html" class="popular_btn">Beach</a>
                                    <a href="/PopularPage/popular.html#temple" class="popular_btn">Temple</a>
                                    <a href="/PopularPage/popular.html#mountain" class="popular_btn">Hiking</a>
                                    <a href="/PopularPage/popular.html#waterpark" class="popular_btn">Waterpark</a>
                                </div>
                            </div>
                        </section>

                        <!-- RECOMMANDATION DESTINATION -->
                        <section id="recommand">
                            <div class="covid" id="covid">
                                <center>
                                    <span class="covid_subtitle">Covid-free Travel Recommendations</span>
                                    <span class="covid_title">NEW OUR FEATURE DESTINATION</span>
                                </center>
                                <div class="covid_content">
                                    <div class="covid_left me-xl-1">
                                        <img src="./Assets/oleleCrop.jpg" class="covid_leftImgg" alt="">
                                    </div>
                                    <div class="covid_right ms-xl-1">
                                        <span class="covid_recommand">The Beautiful View Taman Laut Olele Gorontalo (Sulawesi, Indonesia)</span>
                                        <span class="covid_desc">Taman Laut Olele salah satu ikon wisata di Gorontalo dengan pemandangan
                                            bawah laut yang cantiik dengan terumbu karang warna-warni. Wisata bahari ini terletak di Desa
                                            Olele, Kecamatan Kabila Bone, Gorontalo, Provinsi Gorontalo.
                                            <span class="d-block mt-2">Penyebaran Covid-19 di Gorontalo sampai 2 Maret 2022 sebanyak 12.981 kasus, menjadikan Gorontalo sebagai
                                                Provinsi dengan penyebaran Covid-19 paling sedikit dari 32 Provinsi. </span><span class="covid_source d-block mt-2">Source: <a target="_blank" href="https://covid19.go.id/peta-sebaran">covid19.go.id</a> </span>
                                        </span>
                                        <a class="covid_btn" href="">Visited <i class="uil uil-map-pin-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- ITEM DESTINASI -->
                    <section id="destinasi" class="destinasi">
                        <div class="card_titlee">
                            <center>
                                <span class="card_subtitle">Let's Go explore</span>
                                <span class="card_title">Top Destination</span>
                            </center>
                        </div>
                        <div class="body_item mb-5">
                            <div class="wrapperr">
                                <?php
                                $destinasi = mysqli_query($connect, "SELECT * FROM hotel");
                                $callDestinasi = mysqli_fetch_array($destinasi);
                                while ($callDestinasi = mysqli_fetch_array($destinasi)) {
                                    echo "
                            <div class='card_destination'>
                                <img src='./Assets/" . $callDestinasi['thumbnail'] . "' />
                                <span><strong>Popular</strong> Choice</span>
                                <div class='infoo'>
                                    <div><h5>" . $callDestinasi['thumbnailTitle'] . "</h5></div>
                                    <div><p><small><small>" . $callDestinasi['thumbnailSubTitle'] . "</small></small></p></div>
                                    <div><a href='detail_hotel.php?id_hotel=" . $callDestinasi['id_hotel'] . "'>view hotel &nbsp;<span class='uil uil-arrow-up-right'></span></a></div>
                                </div>
                            </div>
                            ";
                                }
                                ?>
                            </div>
                        </div>
                    </section>

                    <!-- TESTIMONI -->
                    <div class="container-fluid">
                        <section id="recommand">
                            <div class="covid" id="covid">
                                <center>
                                    <span class="covid_subtitle">Our Service</span>
                                    <span class="covid_title">WHY CHOOSE US</span>
                                </center>
                                <div class="covid_content align-items-center">
                                    <div class="testi_left me-xl-2">
                                        <img src="./Assets/body-checkup.svg" class="testi_leftImg" alt="">
                                    </div>
                                    <div class="testi_right ms-xl-2">
                                        <span class="covid_recommand">Travel Insurane</span>
                                        <span class="covid_desc">Kami menyediakan asuransi agar selama perjalanan anda semakin aman & nyaman</span>
                                    </div>
                                </div>
                                <div class="covid_content align-items-center">
                                    <div class="testi_left me-xl-2 order-xl-3">
                                        <img src="./Assets/vaccination.svg" class="testi_leftImg" alt="">
                                    </div>
                                    <div class="testi_right ms-xl-2 order-xl-1">
                                        <span class="covid_recommand text-xl-end">Medical Care</span>
                                        <span class="covid_desc text-xl-end">Mecial Care dapat membantu Anda mengetahui wilayah yang mengalami <span class="d-sm-block">dampak Covid-19 terrendah. Sehingga dapat menjadi rekomendasi anda berwisata</span> </span>
                                    </div>
                                </div>
                                <div class="covid_content align-items-center">
                                    <div class="testi_left me-xl-2">
                                        <img src="./Assets/pharmacy-store.svg" class="testi_leftImg" alt="">
                                    </div>
                                    <div class="testi_right ms-xl-2">
                                        <span class="covid_recommand">Customer Care</span>
                                        <span class="covid_desc">Kami mengedepankan komunikasi dengan customer, karena kepuasan Anda nomor 1.</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- FOOTER -->
                    <div class="footer">
                        <div class="container ">
                            <div class="footer_item ">
                                <div class="footer_left ">
                                    <img src="./Assets/tour (1).png" alt="">
                                </div>
                                <div class="footer_midle1 ">
                                    <h5 class="">Navigasi Menu</h5>
                                    <a href="#" class="footer_desc">
                                        <p class="footer_text ">Home</p>
                                    </a>
                                    <a href="#popular" class="footer_desc">
                                        <p class="footer_text ">Popular Search</p>
                                    </a>
                                    <a href="#recommand" class="footer_desc">
                                        <p class="footer_text ">New Feature</p>
                                    </a>
                                    <a href="#destinasi" class="footer_desc">
                                        <p class="footer_text ">Top Destination</p>
                                    </a>
                                </div>
                                <div class="footer_midle2 ">
                                    <h5 class="">Plan Trip</h5>
                                    <a target="_blank" href="https://www.google.co.id/maps/search/tempat+wisata+bandung/@-6.9034341,107.5731166,12z/data=!3m1!4b1" class="footer_desc">
                                        <p class="footer_text ">Bandung</p>
                                    </a>
                                    <a target="_blank" href="https://www.google.co.id/maps/search/tempat+wisata+yogyakarta/@-7.8103872,110.3370389,12z/data=!3m1!4b1" class="footer_desc">
                                        <p class="footer_text ">Yogyakarta</p>
                                    </a>
                                    <a target="_blank" href="https://www.google.co.id/maps/search/tempat+wisata+bali/@-8.4875766,114.7511165,10z/data=!3m1!4b1" class="footer_desc">
                                        <p class="footer_text ">Bali</p>
                                    </a>
                                    <a target="_blank" href="https://www.google.co.id/maps/search/tempat+wisata+aceh/@4.2648908,95.419864,8z/data=!3m1!4b1" class="footer_desc">
                                        <p class="footer_text ">Aceh</p>
                                    </a>
                                </div>
                                <div class="footer_right ">
                                    <h5 class="">Contact Us</h5>
                                    <a href=" " class="footer_desc">
                                        <p class="footer_text ">Email : kel3brpl@gmail.com</p>
                                    </a>
                                    <a href=" " class="footer_desc">
                                        <p class="footer_text ">Telp : +62 3456 7890</p>
                                    </a>
                                    <div class="">
                                        <a href="https://www.instagram.com/traveloka/" target="_blank" class="footer_desc">
                                            <i class="uil uil-instagram footer_text"></i>
                                        </a>
                                        <a href="https://api.whatsapp.com/send/?phone=%2B6289527363619&text=Hello%2C+Saya+mau+booking+hotel&app_absent=0" target="_blank" class="footer_desc">
                                            <i class="uil uil-whatsapp footer_text"></i>
                                        </a>
                                        <a href="https://www.agoda.com/id-id/?device=c&network=g&adid=578100715837&rand=87709820237095125&expid=&adpos=&aud=kwd-1642406941430&site_id=1891460&tag=add4f21c-9727-432d-af31-4f6ef17064e8&gclid=Cj0KCQjw_4-SBhCgARIsAAlegrVpdJRO8796yAmVSEn4H667vE8H2oHlcP-MH7eRyY7Eqxuwc7fmpZwaAgOFEALw_wcB" target="_blank" class="footer_desc">
                                            <i class="uil uil-browser footer_text"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ADMIN PAGE -->
                <?php
                if ($callback['admin'] != 0) {
                ?>
                    <div class="adminPage d-none">
                        <div class="container-fluid">
                            <?php
                            include('adminPage.php');
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="./JS/scripts.js"></script>
    <!-- WEB LOAD -->
    <script>
        $(document).ready(function() {
            $(".Sidebar_toggle").click(function() {
                $('.mainBody').toggleClass('overlay_Active')
                // $("#sidebars").toggleClass("toggle");
                $("body").toggleClass("overflow-hide");
            });

            $('.mainBody').click(function() {
                $(this).toggleClass('overlay_Active')
                $("#Hide_sidebar").removeClass("sb-sidenav-toggled")
                $("body").toggleClass("overflow-hide");
            });

            $('.click_menu').click(function() {
                $('.mainBody').removeClass('overlay_Active')
                $("#Hide_sidebar").removeClass("sb-sidenav-toggled")
                $("body").removeClass("overflow-hide");
            });

            $('.click_book').click(function() {
                $('.mainBody').removeClass('overlay_Active')
                $("#Hide_sidebar").removeClass("sb-sidenav-toggled")
                $("body").removeClass("overflow-hide");
                var form = $(this).attr('id');
                if (form == "setting") {
                    $('.homePage').addClass('d-none');
                    $('.tradePage').addClass('d-none');
                    $('.settingPage').removeClass('d-none');
                    $('.mapKeyPage').addClass('d-none');
                    $('.coinPage').addClass('d-none');
                    $('.nav_home').addClass('d-none');
                    $('.nav_trade').addClass('d-none');
                    $('.nav_setting').removeClass('d-none');
                    $('.nav_key').addClass('d-none');
                    $('.nav_coin').addClass('d-none');
                    $('.nav_admin').addClass('d-none');
                    $('.adminPage').addClass('d-none');
                }
            });

            $('.click_menu').click(function() {
                var menu = $(this).attr('id');
                if (menu == "dashboard") {
                    $('.homePage').removeClass('d-none');
                    $('.tradePage').addClass('d-none');
                    $('.settingPage').addClass('d-none');
                    $('.mapKeyPage').addClass('d-none');
                    $('.coinPage').addClass('d-none');
                    $('.adminPage').addClass('d-none');
                    $('.nav_admin').addClass('d-none');
                    $('.nav_home').removeClass('d-none');
                    $('.nav_trade').addClass('d-none');
                    $('.nav_setting').addClass('d-none');
                    $('.nav_key').addClass('d-none');
                    $('.nav_coin').addClass('d-none');
                } else if (menu == "trade") {
                    $('.homePage').addClass('d-none');
                    $('.tradePage').removeClass('d-none');
                    $('.settingPage').addClass('d-none');
                    $('.mapKeyPage').addClass('d-none');
                    $('.coinPage').addClass('d-none');
                    $('.adminPage').addClass('d-none');
                    $('.nav_admin').addClass('d-none');
                    $('.nav_home').addClass('d-none');
                    $('.nav_trade').removeClass('d-none');
                    $('.nav_setting').addClass('d-none');
                    $('.nav_key').addClass('d-none');
                    $('.nav_coin').addClass('d-none');
                } else if (menu == "setting") {
                    $('.homePage').addClass('d-none');
                    $('.tradePage').addClass('d-none');
                    $('.settingPage').removeClass('d-none');
                    $('.mapKeyPage').addClass('d-none');
                    $('.coinPage').addClass('d-none');
                    $('.adminPage').addClass('d-none');
                    $('.nav_admin').addClass('d-none');
                    $('.nav_home').addClass('d-none');
                    $('.nav_trade').addClass('d-none');
                    $('.nav_setting').removeClass('d-none');
                    $('.nav_key').addClass('d-none');
                    $('.nav_coin').addClass('d-none');
                } else if (menu == "key") {
                    $('.homePage').addClass('d-none');
                    $('.tradePage').addClass('d-none');
                    $('.settingPage').addClass('d-none');
                    $('.mapKeyPage').removeClass('d-none');
                    $('.coinPage').addClass('d-none');
                    $('.adminPage').addClass('d-none');
                    $('.nav_admin').addClass('d-none');
                    $('.nav_home').addClass('d-none');
                    $('.nav_trade').addClass('d-none');
                    $('.nav_setting').addClass('d-none');
                    $('.nav_key').removeClass('d-none');
                    $('.nav_coin').addClass('d-none');
                } else if (menu == "coinInOut") {
                    $('.homePage').addClass('d-none');
                    $('.tradePage').addClass('d-none');
                    $('.settingPage').addClass('d-none');
                    $('.mapKeyPage').addClass('d-none');
                    $('.coinPage').removeClass('d-none');
                    $('.adminPage').addClass('d-none');
                    $('.nav_admin').addClass('d-none');
                    $('.nav_home').addClass('d-none');
                    $('.nav_trade').addClass('d-none');
                    $('.nav_setting').addClass('d-none');
                    $('.nav_key').addClass('d-none');
                    $('.nav_coin').removeClass('d-none');
                } else if (menu == "admin") {
                    $('.homePage').addClass('d-none');
                    $('.tradePage').addClass('d-none');
                    $('.settingPage').addClass('d-none');
                    $('.mapKeyPage').addClass('d-none');
                    $('.coinPage').addClass('d-none');
                    $('.adminPage').removeClass('d-none');
                    $('.nav_admin').removeClass('d-none');
                    $('.nav_home').addClass('d-none');
                    $('.nav_trade').addClass('d-none');
                    $('.nav_setting').addClass('d-none');
                    $('.nav_key').addClass('d-none');
                    $('.nav_coin').addClass('d-none');
                }
            });
        });
    </script>
    <!-- ACTIVE SIDEBAR -->
    <script>
        var header = document.getElementById("myNav");
        var btns = header.getElementsByClassName("List_item");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                // element.classList.remove('active');
                var current = document.getElementsByClassName("active");
                // element.classList.remove('active');
                current[0].className = current[0].className.replace("active", "");
                // element.classList.remove('active');
                this.className += " active";
                // element.classList.remove('active');
                // var x = document.getElementsByClassName("List_item");
                // x.classList.remove("active");
            });
        }
    </script>
</body>

</html>