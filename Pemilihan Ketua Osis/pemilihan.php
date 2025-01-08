<?php
session_start();
include('db.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$status = $_SESSION['status'];

// Cek apakah siswa sudah memilih
if ($status == 'sudah memilih') {
    echo "Anda sudah memilih!";
    exit();
}

// Ambil data kandidat dari database
$sql = "SELECT * FROM kandidat";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan Ketua OSIS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Pemilihan Ketua OSIS</h2>
    <form action="voting_process.php" method="POST">
        <div class="form-group">
            <label for="kandidat">Pilih Ketua OSIS:</label>
            <select class="form-control" id="kandidat" name="kandidat_id" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['kandidat_id']; ?>"><?php echo $row['nama']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Vote</button>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
