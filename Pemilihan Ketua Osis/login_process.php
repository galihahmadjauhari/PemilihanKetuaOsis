<?php
session_start();
include('db.php');

// Ambil data dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// Query untuk memeriksa email dan password
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Cek apakah password benar
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['status'] = $row['status'];
        header("Location: pemilihan.php");
    } else {
        echo "Password salah!";
    }
} else {
    echo "Email tidak ditemukan!";
}

$conn->close();
?>
