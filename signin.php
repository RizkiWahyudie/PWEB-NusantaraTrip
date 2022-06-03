<?php

require_once("config.php");
session_start();

$err = "";

if (isset($_POST['login'])) {
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
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $password = md5($password);

    if ($username == '' or $password == '') {
        $err = "Please Input Your Username & Password!";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) === 1) {
            // mysqli_fetch_assoc() digunakan untuk mengambil baris hasil sebagai array asosiatif
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id_login'] = $row['id_login'];

                $cookie_username = "cookie_username";
                $cookie_usernamevalue = $username;
                setcookie($cookie_username, $cookie_usernamevalue, time() + (60 * 60 * 24 * 5), '/');
                
                $cookie_password = "cookie_password";
                $cookie_passwordvalue = $password;
                setcookie($cookie_password, $cookie_passwordvalue, time() + (60 * 60 * 24 * 5), '/');
                
                header("Location: formBooking.php");
                exit();
            } else {
                $err = "Username & Password incorrect!";
            }
        } else {
            $err = "Username & Password incorrect!";
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
    <a href="index.html" class="back-home-login"><i class="uil uil-angle-left"></i> Back to home</a>
    <section>
        <div class="Login_side">
            <div class="Login_left">
                <div class="Box_img">
                    <div class="Login_desc">
                        <h1>The Beautiful Place</h1>
                    </div>
                    <img src="Assets/loginn.png" class="Login_img" alt="">
                    <div class="Login_desc">
                        <h4>Start your adventure <br> from now on the Nusantara trip </h4>
                    </div>
                </div>
            </div>
            <div class="Login_right">
                <div class="Login_form">
                    <span class="Login_title">Login</span>
                    <form action="" method="POST">
                        <div class="form_all">
                            <span class="form_title">Username</span>
                            <input type="text" name="username" class="form_input" placeholder="Enter your username">
                            <i class="uil uil-at form_eye"></i>
                        </div>
                        <div class="form_all my-4">
                            <span class="form_title">Password</span>
                            <input type="password" name="password" class="form_input" placeholder="Enter Your Password">
                            <i class="uil uil-lock-alt form_eye"></i>
                        </div>
                        <?php if ($err) { ?>
                            <div style="color: red">
                                <p><?php echo $err ?></p>
                            </div>
                        <?php } ?>
                        <div class="form-check mt-3">
                            <input type="checkbox" value="">
                            <label>
                                &nbsp;Remember me
                            </label>
                            <a href="">Forgot form</a>
                        </div>
                        <div class="Login_btn">
                            <input class="form_btn Btn_form" type="submit" value="LOGIN" name="login" />
                        </div>
                    </form>
                    <a href="signup.php" class="form-regis">Belum Login? Signup</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>