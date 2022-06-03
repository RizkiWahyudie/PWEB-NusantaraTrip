<?php
include("auth.php");

if( isset($_GET['id']) ){

    // ambil id dari query string
    $id = $_GET['id'];

    // buat query hapus
    $sql = "CALL deleteBooking($id)";
    $query = mysqli_query($connect, $sql);

    // apakah query hapus berhasil?
    if( $query ){
        header('Location: formBooking.php?delete=sukses');
    } else {
        die("gagal menghapus...");
    }

} else {
    die("akses dilarang...");
}
