<?php
require_once __DIR__ . '/api/admin_guard.php';
require_once __DIR__ . '/config/koneksi.php';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="tinggalkan-jejak-cerita-' . date('Y-m-d') . '.csv"');
header('Cache-Control: no-store, no-cache, must-revalidate');

function csvSafe($value): string
{
    $value = (string)($value ?? '');
    if (preg_match('/^[\\s\\x00-\\x1F]*[=+\\-@]/u', $value)) {
        return "'" . $value;
    }
    return $value;
}

$output = fopen('php://output', 'wb');
if ($output === false) {
    http_response_code(500);
    exit;
}
fwrite($output, "\xEF\xBB\xBF");
fputcsv($output, ['ID', 'Judul', 'Isi cerita', 'Status', 'Tanggal dibuat', 'Nama penulis', 'Email', 'Jurusan'], ',', '"', '');

$sql = "SELECT c.id, c.judul, c.isi, c.status, c.created_at, u.nama, u.email, j.nama AS jurusan
        FROM cerita c
        JOIN users u ON u.id = c.user_id
        LEFT JOIN jurusan j ON j.id = c.jurusan_id
        ORDER BY c.created_at DESC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        (int)$row['id'],
        csvSafe($row['judul']),
        csvSafe($row['isi']),
        csvSafe($row['status']),
        csvSafe($row['created_at']),
        csvSafe($row['nama']),
        csvSafe($row['email']),
        csvSafe($row['jurusan']),
    ], ',', '"', '');
}
fclose($output);
