<?php
require_once 'config.php';

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_alat = trim($_POST['nama_alat'] ?? '');
    $tahun = filter_input(INPUT_POST, 'tahun', FILTER_VALIDATE_INT);
    $merek = trim($_POST['merek'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');

    if ($nama_alat === '' || !$tahun || $tahun < 1901 || $tahun > 2155 || $merek === '' || $lokasi === '') {
        $pesan = 'Mohon isi seluruh kolom dengan data yang valid.';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO alat_elektromedis (nama_alat, tahun, merek, lokasi) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "siss", $nama_alat, $tahun, $merek, $lokasi);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php?status=added");
            exit;
        }
        $pesan = 'Gagal menyimpan data. Silakan coba kembali.';
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alat | UMPKU Medical Inventory</title>
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
        <span class="eyebrow">DATA MASTER / TAMBAH</span>
        <h1>Tambah Data Alat</h1>
        <p>Lengkapi formulir berikut untuk memasukkan alat elektromedis baru ke dalam inventaris.</p>
    </section>
    <section class="content-card form-card">
        <div class="form-title">
            <span class="form-title-icon">＋</span>
            <div><h2>Informasi Alat Elektromedis</h2><p>Kolom bertanda * wajib diisi.</p></div>
        </div>
        <?php if ($pesan !== ''): ?><div class="alert alert-error"><?= e($pesan) ?></div><?php endif; ?>
        <form method="POST" action="add.php">
            <div class="form-grid">
                <div class="form-group full">
                    <label for="nama_alat">Nama Alat Elektromedis <span>*</span></label>
                    <input id="nama_alat" type="text" name="nama_alat" maxlength="100" placeholder="Contoh: Patient Monitor" value="<?= e($_POST['nama_alat'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Pengadaan <span>*</span></label>
                    <input id="tahun" type="number" name="tahun" min="1901" max="2155" placeholder="Contoh: 2024" value="<?= e($_POST['tahun'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="merek">Merek Alat <span>*</span></label>
                    <input id="merek" type="text" name="merek" maxlength="100" placeholder="Contoh: Mindray" value="<?= e($_POST['merek'] ?? '') ?>" required>
                </div>
                <div class="form-group full">
                    <label for="lokasi">Lokasi Alat <span>*</span></label>
                    <input id="lokasi" type="text" name="lokasi" maxlength="100" placeholder="Contoh: Ruang ICU" value="<?= e($_POST['lokasi'] ?? '') ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
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
