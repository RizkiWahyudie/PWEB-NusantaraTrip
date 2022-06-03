<?php
include("auth.php");

if (isset($_POST['book'])) {
    $data = mysqli_query($connect, "SELECT * FROM users WHERE username='$_SESSION[username]'");
    $callback = mysqli_fetch_array($data);

    // AMBIL DATA DARI VALUE FORMULIR
    $hotel = $_POST['hotel'];
    $nama = $_POST['nama'];
    $phone = $_POST['phone'];
    $room_type = $_POST['room_type'];
    $tamu = $_POST['tamu'];
    $checkin = $_POST['arrived'];
    $checkout = $_POST['departure'];
    $id_hotel = $_POST['id_hotel'];
    $id_login = $callback['id_login'];
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
    $addData = "INSERT INTO `booking` (`id`, `hotel`, `nama`, `phone`, `room_type`, `tamu`, `arrived`, `departure`, `jml_malam`, `price`, `id_login`, `id_hotel`) 
    VALUES (NULL, '$hotel', '$nama', '$phone', '$type_room', '$tamu', '$checkin', '$checkout', '$jml_malam', '$price', '$id_login', '$id_hotel');";
    $query = mysqli_query($connect, $addData);

    // CEK QUERY APAKAH BERHASIL DISIMPAN APA TIDAK
    if ($query) {
        header('Location: bookDetail.php?status=sukses');
    } else {
        header('Location: bookDetail.php?status=gagal');
    }
}
