<?php

// Konfigurasi Database
$host = "localhost";
$user = "root";
$password = "";
$database = "db_fadhil_elektromedis";

// Koneksi Database
$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mengatur karakter database
mysqli_set_charset($conn, "utf8mb4");

function e($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

?>