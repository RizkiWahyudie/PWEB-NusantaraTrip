<?php

$db_host = "localhost";
$db_user = "rovingst_localhost";
$db_pass = "Rizkiwhyd23";
$db_name = "rovingst_nusantaratrip";

$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
mysqli_select_db($connect, $db_name) or die("Database Tidak Ditemukan");

function query($query)
{
    global $connect;
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function signup($data)
{
    global $connect;

    $username = stripslashes($data['username']);
    $username = mysqli_real_escape_string($connect, $username);
    $name     = stripslashes($data['name']);
    $name     = mysqli_real_escape_string($connect, $name);
    $email    = stripslashes($data['email']);
    $email    = mysqli_real_escape_string($connect, $email);
    $password = stripslashes($data['password']);
    $password = mysqli_real_escape_string($connect, $password);
    $password2 = stripslashes($data['password2']);
    $password2 = mysqli_real_escape_string($connect, $password2);
    $password = password_hash($password, PASSWORD_DEFAULT);

    if ($password !== $password2) {
        echo "<script>alert('konfirmasi password tidak sesuai')</script>";
        return false;
    }

    //insert data ke database
    $query = "INSERT INTO users (username,name,email, password ) VALUES ('$username','$name','$email','$password')";
    mysqli_query($connect, $query);
    return mysqli_affected_rows($connect);
}

//atur variabel
$err        = "";
$username   = "";
$ingataku   = "";