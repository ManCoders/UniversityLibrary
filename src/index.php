<?php

ob_start();
if (!isset($_SESSION['admin'])) {
    header('location: ../index.php');
    exit();
}
ob_end_flush(); ?>
