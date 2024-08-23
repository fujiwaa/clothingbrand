<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

// Website
$web_baseurl = "https://soulniv.com/";

// Date & Time
$datetime = date("Y-m-d H:i:s");

// Database
$db_server = "localhost";
$db_user = "soulnivc_db";
$db_password = "?#vn1Tb&iiRP";
$db_name = "soulnivc_db";

$db = mysqli_connect($db_server, $db_user, $db_password, $db_name);
if (!$db) {
    die("MAINTENANCE");
}

function configuration($key)
{
    global $db;
    $configuration = $db->query("SELECT * FROM configuration WHERE c_key = '$key'");
    $data_configuration = mysqli_fetch_assoc($configuration);
    return $data_configuration['c_value'];
}

function format_datetime($a)
{
    $month = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];
    $split = explode(' ', $a);
    $date = explode('-', $split[0]);
    $format_date = $date[2] . ' ' . $month[$date[1]] . ' ' . $date[0];
    $time = substr($split[1], 0, -3);
    return $format_date . ' - ' . $time;
}

function format_date($a) {
    $month = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];
    $split = explode(' ', $a);
    $date = explode('-', $split[0]);
    $format_date = $date[2].' '.$month[$date[1]].' '.$date[0];
    return $format_date;
}

function format_date_resi($a) {
    $month = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];
    $split = explode('T', $a);
    $date = explode('-', $split[0]);
    $time = explode(':', explode('+', $split[1])[0]);
    $formatted_date = $date[2] . ' ' . $month[$date[1]] . ' ' . $date[0];
    $formatted_time = $time[0] . ':' . $time[1];
    return $formatted_date . ' ' . $formatted_time;
}

function generateRandomNumber() {
    return rand(1000000000000, 9999999999999);
}