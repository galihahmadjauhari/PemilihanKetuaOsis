<?php
session_start();
include('db.php');

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Ambil ID pengguna yang akan dihapus
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Hapus data pengguna dari database
    $sql = "DELETE FROM users WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Pengguna berhasil dihapus!";
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat menghapus pengguna!";
    }
} else {
    $_SESSION['message'] = "ID pengguna tidak valid!";
}

header('Location: admin_dashboard.php');
exit();

$conn->close();
?>
