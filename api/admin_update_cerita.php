<?php
require_once __DIR__ . "/admin_guard.php";
require_once __DIR__ . "/../config/koneksi.php";
$d=json_decode(file_get_contents("php://input"),true);
$id=(int)($d["id"]??0); $status=$d["status"]??"";
$map=["published"=>"approved","pending"=>"pending","rejected"=>"rejected"];
if($id<=0||!isset($map[$status])){http_response_code(400);echo json_encode(["success"=>false,"message"=>"Data tidak valid"]);exit;}
$s=$map[$status];
$stmt=$conn->prepare("UPDATE cerita SET status=? WHERE id=?");
$stmt->bind_param("si",$s,$id);
$stmt->execute();
echo json_encode(["success"=>true,"message"=>"Status diperbarui"]);
?>