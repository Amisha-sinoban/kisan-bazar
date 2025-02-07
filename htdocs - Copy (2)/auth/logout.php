<?php
session_start();
session_destroy();
header("Location: ../signup.php");
exit();
?>
