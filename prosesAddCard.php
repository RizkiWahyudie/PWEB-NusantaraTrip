<?php
include("auth.php");

if( isset($_POST['addCard']) ){
    $nomorRekening = $_POST['nomor_rekening'];
    $nomorKartu = $_POST['nomor_kartu'];
    $nama = $_POST['nama'];
    $pin = $_POST['pin'];
    $saldo = $_POST['saldo'];

    // buat query
    $sql = "CALL addCardPayment($nomorRekening, $nomorKartu, '$nama', $pin, $saldo, @pesan);";
    $query = mysqli_query($connect, $sql);

    // apakah query hapus berhasil?
    if( $query ){
        header('Location: formBooking.php?addCard=sukses');
    } else {
        die("gagal buat kartu...");
    }

} else {
    die("akses dilarang...");
}
