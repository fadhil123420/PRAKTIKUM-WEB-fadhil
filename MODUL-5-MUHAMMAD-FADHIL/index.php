<?php
require_once 'config.php';

$sql = "SELECT * FROM alat_elektromedis ORDER BY id DESC";
$query = mysqli_query($conn, $sql);
if (!$query) {
    die("Gagal mengambil data inventaris.");
}

$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM alat_elektromedis");
$total = (int) mysqli_fetch_assoc($totalResult)['total'];

$tahunResult = mysqli_query($conn, "SELECT COUNT(DISTINCT tahun) AS jumlah FROM alat_elektromedis");
$jumlahTahun = (int) mysqli_fetch_assoc($tahunResult)['jumlah'];

$merekResult = mysqli_query($conn, "SELECT COUNT(DISTINCT merek) AS jumlah FROM alat_elektromedis");
$jumlahMerek = (int) mysqli_fetch_assoc($merekResult)['jumlah'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem informasi inventaris alat elektromedis UMPKU Surakarta.">
    <title>Dashboard Inventaris | UMPKU</title>
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

<main class="container">
    <section class="welcome-row">
        <div>
            <span class="eyebrow">DASHBOARD / MODUL 05</span>
            <h1>Inventaris Alat Elektromedis</h1>
            <p>Kelola, pantau, dan perbarui data peralatan elektromedis dalam satu sistem.</p>
        </div>
        <a href="add.php" class="btn btn-primary"><span class="plus">＋</span> Tambah Data Alat</a>
    </section>

    <section class="stats-grid" aria-label="Ringkasan inventaris">
        <article class="stat-card">
            <div class="stat-top"><span>Total Inventaris</span><span class="stat-icon orange">▦</span></div>
            <strong><?= $total ?></strong>
            <small>Alat terdaftar dalam database</small>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span>Tahun Pengadaan</span><span class="stat-icon blue">◷</span></div>
            <strong><?= $jumlahTahun ?></strong>
            <small>Variasi tahun pengadaan</small>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span>Merek Alat</span><span class="stat-icon green">◇</span></div>
            <strong><?= $jumlahMerek ?></strong>
            <small>Merek berbeda tercatat</small>
        </article>
    </section>

    <section class="content-card">
        <div class="content-heading">
            <div>
                <span class="eyebrow">DATA MASTER</span>
                <h2>Daftar Inventaris</h2>
                <p>Data alat elektromedis yang tersimpan di database.</p>
            </div>
            <label class="search-box">
                <span>⌕</span>
                <input type="search" id="tableSearch" placeholder="Cari nama, merek, lokasi...">
            </label>
        </div>

        <div class="table-scroll">
            <table id="inventoryTable">
                <thead>
                    <tr>
                        <th class="number-col">No.</th>
                        <th>Nama Alat</th>
                        <th>Tahun</th>
                        <th>Merek</th>
                        <th>Lokasi</th>
                        <th class="action-col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($data = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td class="number-col"><?= $no++ ?></td>
                        <td><strong class="equipment-name"><?= e($data['nama_alat']) ?></strong></td>
                        <td><span class="year-pill"><?= e($data['tahun']) ?></span></td>
                        <td><?= e($data['merek']) ?></td>
                        <td><span class="location-label">⌖ <?= e($data['lokasi']) ?></span></td>
                        <td>
                            <div class="row-actions">
                                <a class="btn btn-edit" href="edit.php?id=<?= (int) $data['id'] ?>">Edit</a>
                                <a class="btn btn-delete" href="delete.php?id=<?= (int) $data['id'] ?>" onclick="return confirm('Yakin ingin menghapus data <?= e($data['nama_alat']) ?>?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="empty-state">Belum ada data inventaris. Silakan tambahkan data alat pertama.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            <p id="noSearchResult" class="empty-state" hidden>Data yang kamu cari tidak ditemukan.</p>
        </div>
        <div class="table-foot">
            <span>Menampilkan data inventaris terbaru</span>
            <span><?= $total ?> data tersimpan</span>
        </div>
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

<script>
const searchInput = document.getElementById('tableSearch');
const tableRows = document.querySelectorAll('#inventoryTable tbody tr');
const noResult = document.getElementById('noSearchResult');

searchInput.addEventListener('input', function () {
    const keyword = this.value.toLocaleLowerCase('id').trim();
    let visible = 0;

    tableRows.forEach((row) => {
        const match = row.innerText.toLocaleLowerCase('id').includes(keyword);
        row.hidden = !match;
        if (match) visible++;
    });

    noResult.hidden = visible !== 0 || keyword === '';
});
</script>
</body>
</html>
