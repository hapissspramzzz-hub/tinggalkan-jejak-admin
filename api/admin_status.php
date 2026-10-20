<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
echo json_encode(["success"=>true,"logged_in"=>!empty($_SESSION["admin_logged_in"])]);
?>