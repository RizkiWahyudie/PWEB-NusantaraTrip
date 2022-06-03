<?php
require_once("config.php");
session_start();

//mengecek username pada session
// Fungsi isset () digunakan untuk memeriksa apakah suatu variabel sudah diatur atau belum
if (!isset($_SESSION['username'])) {
    header('Location: index.html');
}

?>