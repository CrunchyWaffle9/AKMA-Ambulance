<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "reparasi_ambulance";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){
    die("Gagal terkoneksi");
}
