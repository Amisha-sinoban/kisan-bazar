<?php
session_start();
$_SESSION['test'] = "Session Working!";
echo json_encode(["session_id" => session_id(), "session_data" => $_SESSION]);
?>
