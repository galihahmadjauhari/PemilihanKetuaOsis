<?php
session_start();
include('db.php');

// Variabel untuk menyimpan pesan error
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    // Validasi form
    if (empty($email) || empty($password) || empty($nama) || empty($kelas)) {
        $error = "Semua field harus diisi!";
    } else {
        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah email sudah terdaftar
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Jika email sudah terdaftar
            $error = "Email sudah terdaftar!";
        } else {
            // Simpan data pengguna baru ke dalam database
            $sql = "INSERT INTO users (email, password, nama, kelas, status) 
                    VALUES ('$email', '$hashed_password', '$nama', '$kelas', 'belum memilih')";
            
            if ($conn->query($sql) === TRUE) {
                // Daftar berhasil
                $_SESSION['message'] = "Pendaftaran berhasil! Silakan login.";
                header("Location: login.php");
                exit();
            } else {
                // Jika terjadi kesalahan saat menyimpan data
                $error = "Terjadi kesalahan: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Pendaftaran Akun</h2>

        <?php if ($error != ""): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" required>
            </div>

            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>

        <p class="mt-3">Sudah memiliki akun? <a href="login.php">Login disini</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
