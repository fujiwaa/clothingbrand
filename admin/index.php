<?php
session_start();
require '../config.php';

if ($_SESSION['user'] AND $_SESSION['user']['level'] == 'Admin') {
    header("Location: dashboard");
} else {
    header("Location: ".$web_baseurl."profile");
}