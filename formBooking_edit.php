<?php
include("auth.php");

if (!isset($_GET['id'])) {
    header('location: formBooking.php');
}

// ambil id dari query string
$id = $_GET['id'];

// buat query hapus
$sql = "SELECT * FROM booking WHERE id=$id";
$query = mysqli_query($connect, $sql);
$book = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) < 1) {
    die("data tidak ditemukan...");
}

if (isset($_POST['book'])) {
    // AMBIL DATA DARI VALUE FORMULIR
    $hotel = $_POST['hotel'];
    $nama = $_POST['nama'];
    $phone = $_POST['phone'];
    $room_type = $_POST['room_type'];
    $tamu = $_POST['tamu'];
    $checkin = $_POST['arrived'];
    $checkout = $_POST['departure'];
    $id_hotel = $_POST['id_hotel'];
    $query    = mysqli_query($connect, "SELECT * FROM hotel WHERE id_hotel='$id_hotel'");
    $result    = mysqli_fetch_array($query);

    // MEMBUAT SELISIH HARI CHECKIN CHECKOUT
    function SelisihHari($CheckIn, $CheckOut)
    {
        $CheckInX = explode("-", $CheckIn);
        $CheckOutX =  explode("-", $CheckOut);
        $_POST['arrived'] =  mktime(0, 0, 0, $CheckInX[1], $CheckInX[2], $CheckInX[0]);
        $_POST['departure'] =  mktime(0, 0, 0, $CheckOutX[1], $CheckOutX[2], $CheckOutX[0]);
        $interval = ($_POST['departure'] - $_POST['arrived']) / (3600 * 24);
        // returns numberofdays
        return  $interval;
    }

    // MODIFIKASI DAN MANIPULASI DATA TYPE ROOM UNTUK TOTAL HARGA DAN TYPE ROOM
    if ($room_type === "1") {
        $price = $result['priceTypeOne'] * SelisihHari($_POST['arrived'], $_POST['departure']);
        $type_room = "Private Room";
    } else if ($room_type === "2") {
        $price = $result['priceTypeTwo'] * SelisihHari($_POST['arrived'], $_POST['departure']);
        $type_room = "Deluxe Room";
    } else if ($room_type === "3") {
        $price = $result['priceTypeThree'] * SelisihHari($_POST['arrived'], $_POST['departure']);
        $type_room = "Party Room";
    }

    $jml_malam = SelisihHari($checkin, $checkout);

    // MEMBUAT QUERY
    $addData = "UPDATE booking SET hotel='$hotel', nama='$nama', phone='$phone', room_type='$type_room', 
    jml_malam='$jml_malam', tamu='$tamu', arrived='$checkin' , departure='$checkout', price='$price' WHERE id=$id";
    $query = mysqli_query($connect, $addData);

    // CEK QUERY APAKAH BERHASIL DISIMPAN APA TIDAK
    if ($query) {
        header('Location: formBooking.php?status=sukses');
    } else {
        die('Gagal disimpan');
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nusantara Trip</title>
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
</head>

<body class="formEdit">
    <div class="container mt-4 mb-3">
        <div class="detail-book bg-white">
            <form action="" method="POST">
                <input name="id_hotel" type="hidden" value="<?php echo $book['id_hotel'] ?>">
                <div class="">
                    <label>Hotel</label>
                    <input readonly type="text" name="hotel" placeholder="Enter Your Hotel" value="<?php echo $book['hotel'] ?>" />
                </div>
                <div class="detail-form">
                    <div>
                        <label class="mt-2">Name</label>
                        <input readonly type="text" name="nama" placeholder="Enter Your Name" value="<?php echo $book['nama'] ?>" />
                    </div>
                    <div class="mt-2">
                        <label class="">Phone</label>
                        <input readonly type="text" name="phone" placeholder="Enter Your Phone" value="<?php echo $book['phone'] ?>" />
                    </div>
                </div>
                <div class="mt-2">
                    <label>Room Type</label>
                    <select name="room_type">
                        <option value="1" <?php echo ($book['room_type'] == 'Private Room') ? "selected" : "" ?>>Private Room (1 to 2 people)</option>
                        <option value="2" <?php echo ($book['room_type'] == 'Deluxe Room') ? "selected" : "" ?>>Deluxe Room (3 to 6 people)</option>
                        <option value="3" <?php echo ($book['room_type'] == 'Party Room') ? "selected" : "" ?>>Party Room (Up to 7 people)</option>
                    </select>
                </div>
                <div class="mt-2">
                    <label>Number of Guests</label>
                    <select name="tamu">
                        <option value="1" <?php echo ($book['tamu'] == '1') ? "selected" : "" ?>>1</option>
                        <option value="2" <?php echo ($book['tamu'] == '2') ? "selected" : "" ?>>2</option>
                        <option value="3" <?php echo ($book['tamu'] == '3') ? "selected" : "" ?>>3</option>
                        <option value="4" <?php echo ($book['tamu'] == '4') ? "selected" : "" ?>>4</option>
                        <option value="5" <?php echo ($book['tamu'] == '5') ? "selected" : "" ?>>5</option>
                        <option value="6" <?php echo ($book['tamu'] == '6') ? "selected" : "" ?>>6</option>
                        <option value="7" <?php echo ($book['tamu'] == '7') ? "selected" : "" ?>>7</option>
                        <option value="8" <?php echo ($book['tamu'] == '8') ? "selected" : "" ?>>8</option>
                    </select>
                </div>
                <div class="detail-form">
                    <div>
                        <label class="mt-2">Arrival Date</label>
                        <input type="date" name="arrived" value="<?php echo $book['arrived'] ?>" />
                    </div>
                    <div class="mt-2">
                        <label class="">Departure Date</label>
                        <input type="date" name="departure" value="<?php echo $book['departure'] ?>" />
                    </div>
                </div>
                <input class="submit mt-4" type="submit" value="UPDATE BOOKING" name="book" />
            </form>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="./JS/scripts.js"></script>
</body>

</html>