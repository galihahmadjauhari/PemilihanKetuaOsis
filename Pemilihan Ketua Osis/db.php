<?php
$servername = "localhost";
$username = "root";  // ganti dengan username database Anda
$password = "";  // ganti dengan password database Anda
$dbname = "data2";  // ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
