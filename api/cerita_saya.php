<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/koneksi.php';

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Silakan masuk']);
    exit;
}

$userId = (int) $_SESSION['user_id'];
$statement = $conn->prepare(
    "SELECT c.id,c.judul AS title,c.isi AS content,c.status,c.created_at AS tanggal,
            COALESCE(NULLIF(j.nama,''),NULLIF(c.jurusan_nama,'')) AS fakultasTag
     FROM cerita c
     LEFT JOIN jurusan j ON j.id=c.jurusan_id
     WHERE c.user_id=?
     ORDER BY c.created_at DESC"
);
$statement->bind_param('i', $userId);
$statement->execute();
$rows = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

foreach ($rows as &$row) {
    $row['snippet'] = mb_substr($row['content'], 0, 90) . (mb_strlen($row['content']) > 90 ? '…' : '');
}
unset($row);

echo json_encode(['success' => true, 'data' => $rows], JSON_UNESCAPED_UNICODE);