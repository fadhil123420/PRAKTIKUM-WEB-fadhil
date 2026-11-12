<?php
require_once 'config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    die('ID alat tidak valid. <a href="index.php">Kembali ke dashboard</a>');
}

$stmt = mysqli_prepare($conn, "DELETE FROM alat_elektromedis WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    header("Location: index.php?status=" . ($affected > 0 ? "deleted" : "notfound"));
    exit;
}

mysqli_stmt_close($stmt);
http_response_code(500);
die('Gagal menghapus data alat. <a href="index.php">Kembali ke dashboard</a>');
?>