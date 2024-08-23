<?php
session_start();

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];
    $_SESSION['recent_searches'][] = $searchTerm;
}