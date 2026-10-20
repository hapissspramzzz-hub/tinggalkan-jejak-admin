<?php
require_once __DIR__.'/../config/session.php';
header("Content-Type: application/json; charset=UTF-8");
if (empty($_SESSION["admin_logged_in"])) {
 http_response_code(401);
 echo json_encode(["success"=>false,"message"=>"Akses admin ditolak. Silakan login."]);
 exit;
}
?>