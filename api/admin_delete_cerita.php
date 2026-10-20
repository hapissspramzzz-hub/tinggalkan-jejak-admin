<?php
require_once __DIR__ . "/admin_guard.php";
require_once __DIR__ . "/../config/koneksi.php";
$d=json_decode(file_get_contents("php://input"),true); $id=(int)($d["id"]??0);
$stmt=$conn->prepare("DELETE FROM cerita WHERE id=?"); $stmt->bind_param("i",$id);
$stmt->execute(); echo json_encode(["success"=>true,"message"=>"Cerita dihapus"]);
?>