<?php

session_start();
session_destroy();
header("Location: index.html");

?>

<!-- php -S localhost:8000 -->