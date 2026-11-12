<?php
require_once 'config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    die('ID alat tidak valid. <a href="index.php">Kembali ke dashboard</a>');
}

$stmt = mysqli_prepare($conn, "SELECT id, nama_alat, tahun, merek, lokasi FROM alat_elektromedis WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$data) {
    http_response_code(404);
    die('Data alat tidak ditemukan. <a href="index.php">Kembali ke dashboard</a>');
}

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_alat = trim($_POST['nama_alat'] ?? '');
    $tahun = filter_input(INPUT_POST, 'tahun', FILTER_VALIDATE_INT);
    $merek = trim($_POST['merek'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');

    if ($nama_alat === '' || !$tahun || $tahun < 1901 || $tahun > 2155 || $merek === '' || $lokasi === '') {
        $pesan = 'Mohon isi seluruh kolom dengan data yang valid.';
        $data = array_merge($data, [
            'nama_alat' => $nama_alat,
            'tahun' => $_POST['tahun'] ?? '',
            'merek' => $merek,
            'lokasi' => $lokasi
        ]);
    } else {
        $update = mysqli_prepare($conn, "UPDATE alat_elektromedis SET nama_alat = ?, tahun = ?, merek = ?, lokasi = ? WHERE id = ?");
        mysqli_stmt_bind_param($update, "sissi", $nama_alat, $tahun, $merek, $lokasi, $id);

        if (mysqli_stmt_execute($update)) {
            mysqli_stmt_close($update);
            header("Location: index.php?status=updated");
            exit;
        }
        $pesan = 'Gagal memperbarui data. Silakan coba kembali.';
        mysqli_stmt_close($update);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alat | UMPKU Medical Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a class="brand" href="index.php">
            <img src="logo-umpku.png" alt="Logo Universitas Muhammadiyah PKU Surakarta">
            <span class="brand-divider"></span>
            <span class="brand-copy">
                <strong>MEDICAL INVENTORY SYSTEM</strong>
                <small>Sistem Informasi Inventaris Alat Elektromedis</small>
            </span>
        </a>
        <div class="header-meta">
            <span class="live-dot"></span>
            <span>SISTEM INVENTARIS</span>
        </div>
    </div>
</header>
<nav class="main-nav">
    <div class="nav-inner">
        <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Dashboard</a>
        <a href="add.php" class="<?= basename($_SERVER['PHP_SELF']) === 'add.php' ? 'active' : '' ?>">Tambah Alat</a>
    </div>
</nav>

<main class="container form-container">
    <a class="back-link" href="index.php">← Kembali ke dashboard</a>
    <section class="form-intro">
        <span class="eyebrow">DATA MASTER / PERBARUI</span>
        <h1>Edit Data Alat</h1>
        <p>Perbarui informasi alat elektromedis yang telah tersimpan.</p>
    </section>
    <section class="content-card form-card">
        <div class="form-title">
            <span class="form-title-icon">✎</span>
            <div><h2>Perbarui Informasi Alat</h2><p>ID data: #<?= (int) $id ?></p></div>
        </div>
        <?php if ($pesan !== ''): ?><div class="alert alert-error"><?= e($pesan) ?></div><?php endif; ?>
        <form method="POST" action="edit.php?id=<?= (int) $id ?>">
            <div class="form-grid">
                <div class="form-group full">
                    <label for="nama_alat">Nama Alat Elektromedis <span>*</span></label>
                    <input id="nama_alat" type="text" name="nama_alat" maxlength="100" value="<?= e($data['nama_alat']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Pengadaan <span>*</span></label>
                    <input id="tahun" type="number" name="tahun" min="1901" max="2155" value="<?= e($data['tahun']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="merek">Merek Alat <span>*</span></label>
                    <input id="merek" type="text" name="merek" maxlength="100" value="<?= e($data['merek']) ?>" required>
                </div>
                <div class="form-group full">
                    <label for="lokasi">Lokasi Alat <span>*</span></label>
                    <input id="lokasi" type="text" name="lokasi" maxlength="100" value="<?= e($data['lokasi']) ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </section>
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <strong>UNIVERSITAS MUHAMMADIYAH PKU SURAKARTA</strong>
            <p>Medical Inventory System · Program Studi D4 Elektromedis</p>
        </div>
        <div class="footer-student">
            <span>Dikembangkan sebagai tugas praktikum oleh</span>
            <strong>Muhammad Fadhil Muqorrobin · 1202405022</strong>
        </div>
    </div>
    <div class="footer-bottom">© <?= date('Y') ?> · Modul 5 Praktikum Pemrograman Web</div>
</footer>

</body>
</html>
