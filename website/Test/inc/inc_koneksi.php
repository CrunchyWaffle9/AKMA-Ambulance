<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "company_profile";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){
    die("Gagal terkoneksi");
}
