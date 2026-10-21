<?php
require_once __DIR__ . "/admin_guard.php";
require_once __DIR__ . "/../config/koneksi.php";
$sql="SELECT c.id,c.judul AS title,c.isi AS content,
CASE WHEN c.status='approved' THEN 'published' ELSE c.status END AS status,
c.created_at AS tanggal,u.nama AS authorName,u.angkatan,
COALESCE(NULLIF(j.nama,''),NULLIF(c.jurusan_nama,'')) AS fakultasTag
FROM cerita c JOIN users u ON u.id=c.user_id
LEFT JOIN jurusan j ON j.id=c.jurusan_id ORDER BY c.created_at DESC";
$r=$conn->query($sql); $data=[];
if(!$r){echo json_encode(["success"=>false,"message"=>$conn->error]);exit;}
while($row=$r->fetch_assoc()){$data[]=$row;}
echo json_encode(["success"=>true,"data"=>$data]);
?>