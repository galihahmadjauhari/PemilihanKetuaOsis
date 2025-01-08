<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$kandidat_id = $_POST['kandidat_id'];

// Cek apakah siswa sudah memilih
$sql_check = "SELECT * FROM voting WHERE user_id = '$user_id'";
$result_check = $conn->query($sql_check);
if ($result_check->num_rows > 0) {
    echo "Anda sudah memilih!";
    exit();
}

// Simpan voting ke dalam tabel voting
$sql_vote = "INSERT INTO voting (user_id, kandidat_id) VALUES ('$user_id', '$kandidat_id')";
if ($conn->query($sql_vote) === TRUE) {
    // Update status siswa menjadi sudah memilih
    $sql_update_status = "UPDATE users SET status = 'sudah memilih' WHERE user_id = '$user_id'";
    $conn->query($sql_update_status);

    // Update jumlah suara kandidat
    $sql_update_suara = "UPDATE kandidat SET jumlah_suara = jumlah_suara + 1 WHERE kandidat_id = '$kandidat_id'";
    $conn->query($sql_update_suara);

    echo "Terima kasih sudah memilih!";
} else {
    echo "Terjadi kesalahan!";
}

$conn->close();
?>
