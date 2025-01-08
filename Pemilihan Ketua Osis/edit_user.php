<?php
session_start();
include('db.php');

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Ambil ID pengguna yang akan diedit
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Ambil data pengguna dari database
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Pengguna tidak ditemukan!";
        header('Location: admin_dashboard.php');
        exit();
    }
} else {
    $_SESSION['message'] = "ID pengguna tidak valid!";
    header('Location: admin_dashboard.php');
    exit();
}

// Proses pembaruan data pengguna
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    // Update data pengguna
    $sql = "UPDATE users SET status = '$status' WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Status pengguna berhasil diperbarui!";
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat memperbarui status pengguna!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Pengguna</h2>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="edit_user.php?id=<?php echo $user['user_id']; ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="belum memilih" <?php echo ($user['status'] == 'belum memilih') ? 'selected' : ''; ?>>Belum Memilih</option>
                    <option value="sudah memilih" <?php echo ($user['status'] == 'sudah memilih') ? 'selected' : ''; ?>>Sudah Memilih</option>
                    <option value="admin" <?php echo ($user['status'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
