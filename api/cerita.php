<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../config/koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    $sql = "SELECT c.id,c.judul AS title,c.isi AS content,c.status,c.created_at AS tanggal,
                   u.nama AS authorName,u.angkatan,
                   COALESCE(NULLIF(j.nama,''),NULLIF(c.jurusan_nama,'')) AS fakultasTag
            FROM cerita c
            JOIN users u ON u.id=c.user_id
            LEFT JOIN jurusan j ON j.id=c.jurusan_id
            WHERE c.status='approved'
            ORDER BY c.created_at DESC";
    $result = $conn->query($sql);
    echo json_encode(['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metode tidak didukung']);
    exit;
}

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Masuk terlebih dahulu']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$data = is_array($data) ? $data : [];
$title = trim($data['judul'] ?? '');
$content = trim($data['isi'] ?? '');
$major = trim($data['jurusan'] ?? '');

if ($title === '' || mb_strlen($title) > 255 || $content === '' || mb_strlen($content) > 20000 || mb_strlen($major) > 150) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Judul dan isi wajib diisi (maksimal 20.000 karakter); nama jurusan maksimal 150 karakter']);
    exit;
}

$majorId = null;
if ($major !== '') {
    $statement = $conn->prepare('SELECT id FROM jurusan WHERE nama=? LIMIT 1');
    $statement->bind_param('s', $major);
    $statement->execute();
    $majorId = $statement->get_result()->fetch_column() ?: null;
}

$statement = $conn->prepare("INSERT INTO cerita(user_id,jurusan_id,jurusan_nama,judul,isi,status) VALUES(?,?,?,?,?,'pending')");
$userId = (int) $_SESSION['user_id'];
$statement->bind_param('iisss', $userId, $majorId, $major, $title, $content);
$statement->execute();

echo json_encode([
    'success' => true,
    'message' => 'Cerita dikirim untuk ditinjau admin',
    'id' => $statement->insert_id,
], JSON_UNESCAPED_UNICODE);
