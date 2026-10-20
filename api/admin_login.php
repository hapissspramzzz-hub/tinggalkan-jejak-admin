<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . "/../config/admin_auth.php";
$data=json_decode(file_get_contents("php://input"),true);
if (($data["password"]??"")===ADMIN_PASSWORD) {
 $_SESSION["admin_logged_in"]=true;
 echo json_encode(["success"=>true,"message"=>"Login berhasil"]);
} else {
 http_response_code(401);
 echo json_encode(["success"=>false,"message"=>"Password salah"]);
}
?>