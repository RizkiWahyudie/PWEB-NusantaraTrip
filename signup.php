<?php

require_once("config.php");
session_start();

if (isset($_POST['register'])) {
    function validate($data)
    {
        // TRIM untuk Menghapus spasi atau karakter standar lainnya dari sisi kiri string
        $data = trim($data);
        // STRIPSLASHES untuk menghapus atau menghilangkan karakter backslashes tanda garis miring terbalik ("") menggunakan stripslashes() sehingga tidak mengganggu query mysql yang dikirim.
        $data = stripslashes($data);
        // htmlspecialchars() dapat digunakan untuk mengubah beberapa karakter yang telah ditentukan menjadi entitas HTML
        $data = htmlspecialchars($data);
        return $data;
    }
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $password2 = validate($_POST['password2']);

    $password = md5($password);
    $checkUsername = mysqli_query($connect, "SELECT username FROM users WHERE username = '$username'");
    // mysqli_fetch_assoc() digunakan untuk mengambil baris hasil sebagai array asosiatif
    if (mysqli_fetch_assoc($checkUsername)) {
        header('Location: signup.php?usernameHasAlreadyTaken');
        return false;
    }
    //insert data ke database
    $query = "INSERT INTO users (username,name,email, password ) VALUES ('$username','$name','$email','$password')";
    $result = mysqli_query($connect, $query);

    // cek jika berhasil disimpan ke database maka akan dipindah halaman ke login.php
    if ($result) {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header('Location: signin.php');
    } else {
        $error =  'Register User Gagal !!';
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
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- ICON HEADER -->
    <link rel="icon" href="./Assets/tour (1).png">
    <!-- ICONSCOUT -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- BOX ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="Style/login.css">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
</head>

<body>
    <a href="index.html" class="back-home"><i class="uil uil-angle-left"></i> Back to home</a>
    <section>
        <div class="Login_side">
            <div class="Signup_left">
                <div class="Login_form">
                    <span class="Login_title">Sign Up</span>
                    <form action="" method="POST">
                        <div class="form_all">
                            <span class="form_title">Name</span>
                            <input type="text" name="name" class="form_input" placeholder="Enter your name" required>
                            <i class="uil uil-at form_eye"></i>
                        </div>
                        <div class="form_all my-4">
                            <span class="form_title">Username</span>
                            <input maxlength="7" type="text" name="username" class="form_input" placeholder="Maximum input username is 7 letters" required>
                            <i class="uil uil-at form_eye"></i>
                        </div>
                        <div class="form_all my-4">
                            <span class="form_title">Email</span>
                            <input type="email" name="email" class="form_input" placeholder="Ex: nana@gmail.com" required>
                            <i class="uil uil-at form_eye"></i>
                        </div>
                        <div class="form_all my-4">
                            <span class="form_title">Password</span>
                            <input type="password" name="password" class="form_input" placeholder="******" required>
                            <i class="uil uil-lock-alt form_eye"></i>
                        </div>
                        <div class="form_all my-4">
                            <span class="form_title">Confirm Passowrd</span>
                            <input type="password" name="password2" class="form_input" placeholder="******" required>
                            <i class="uil uil-lock-alt form_eye"></i>
                        </div>
                        <div class="form-check mt-3">
                            <input type="checkbox" value="">
                            <label>
                                &nbsp;Remember me
                            </label>
                            <a href="">Forgot form</a>
                        </div>
                        <div class="Login_btn">
                            <input onclick="onChange()" class="form_btn Btn_form" type="submit" value="SIGN UP" name="register" />
                        </div>
                    </form>
                    <a href="signin.php" class="form-regis">Sudah Signup? Login</a>
                </div>
            </div>
            <div class="Signup_right">
                <div class="Box_img">
                    <div class="Login_desc">
                        <h1>Plan Your Destination</h1>
                    </div>
                    <img src="Assets/regis.png" class="Signup_img" alt="">
                    <div class="Login_desc">
                        <h4>Start your adventure <br> from now on the Nusantara trip </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function onChange() {
            const password = document.querySelector('input[name=password]');
            const confirm = document.querySelector('input[name=password2]');
            if (confirm.value === password.value) {
                confirm.setCustomValidity('');
            } else {
                confirm.setCustomValidity('Passwords do not match');
            }
        }
    </script>
</body>

</html>