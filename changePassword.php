<?php
$err = "";
if (isset($_POST['change'])) {

    if (
        isset($_POST['op']) && isset($_POST['np'])
        && isset($_POST['c_np'])
    ) {

        function validate($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        $op = validate($_POST['op']);
        $np = validate($_POST['np']);
        $c_np = validate($_POST['c_np']);

        if (empty($op)) {
            $err = "Your password is empty!";
        } else if (empty($np)) {
            $err = "Input your new password!";
        } else if ($np !== $c_np) {
            $err = "New Password and Confirm Password Not Same!";
        } else {
            // hashing the password
            $op = md5($op);
            $np = md5($np);
            $session = mysqli_query($connect, "SELECT * FROM users WHERE username='$_SESSION[username]'");
            $sessionId = mysqli_fetch_array($session);
            $id_session = $sessionId['id_login'];

            $sql_pw = "SELECT password FROM users WHERE id_login='$id_session'";
            $result_pw = mysqli_query($connect, $sql_pw);
            if (mysqli_num_rows($result_pw) === 1) {

                $sql_2 = "UPDATE users SET password='$np' WHERE id_login='$id_session'";
                mysqli_query($connect, $sql_2);
                header("Location: formBooking.php?success=Your password has been changed successfully");
                exit();
            } else {
                $err = "Your Password Incorrect, Please try again!";
            }
        }
    } else {
        header("Location: formBooking.php");
        exit();
    }
}
