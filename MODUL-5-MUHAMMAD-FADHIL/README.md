# MODUL 5 — APLIKASI CRUD INVENTARIS ALAT ELEKTROMEDIS

## Identitas Mahasiswa
- Nama: Muhammad Fadhil Muqorrobin
- NIM: 1202405022
- Program Studi: D4 Elektromedis
- Universitas: Universitas Muhammadiyah PKU Surakarta

## Deskripsi
Aplikasi web CRUD (Create, Read, Update, Delete) untuk mengelola data inventaris alat elektromedis menggunakan PHP Native dan MySQL/MariaDB.

## Teknologi
- PHP Native
- MySQL / MariaDB
- HTML dan CSS
- XAMPP
- Visual Studio Code

## Fitur
1. **Create** — menambahkan data alat elektromedis.
2. **Read** — menampilkan daftar inventaris dan ringkasan jumlah alat, tahun pengadaan, serta merek.
3. **Update** — memperbarui data alat.
4. **Delete** — menghapus data alat setelah konfirmasi.
5. Pencarian cepat pada tabel inventaris (berjalan di browser).

## Struktur Database
- Database: `db_alat_elektromedis`
- Tabel: `alat_elektromedis`
- Kolom: `id`, `nama_alat`, `tahun`, `merek`, `lokasi`

## Cara Menjalankan di XAMPP
1. Salin folder `MODUL-5-MUHAMMAD-FADHIL` ke `C:\xampp\htdocs\`.
2. Buka XAMPP Control Panel, lalu aktifkan **Apache** dan **MySQL**.
3. Buka `http://localhost/phpmyadmin`.
4. Pilih menu **Import**, pilih file `database.sql` dari folder proyek, lalu klik **Import/Go**.
   - File SQL membuat tabel `alat_elektromedis` dan memasukkan lima data contoh yang memang terdapat pada file database yang diberikan.
   - Jika database/tabel dengan nama yang sama sudah ada dan berisi data penting, lakukan backup terlebih dahulu sebelum import.
5. Buka `http://localhost/MODUL-5-MUHAMMAD-FADHIL/`.

## File Program
- `config.php` — koneksi database.
- `index.php` — dashboard dan daftar inventaris.
- `add.php` — tambah data.
- `edit.php` — ubah data.
- `delete.php` — hapus data.
- `style.css` — tampilan antarmuka.
- `database.sql` — struktur dan data awal database.
- `test.php` — tes koneksi database.

## Catatan Perbaikan
File `edit.php` yang diberikan sebelumnya berisi proses INSERT seperti halaman tambah data. Pada versi ini, fungsi tersebut telah diperbaiki menjadi UPDATE berdasarkan ID agar fitur Edit benar-benar memperbarui baris data yang dipilih.
