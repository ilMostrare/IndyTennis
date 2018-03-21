<?php
// session_start();

$admin_id = $_SESSION['adminID'];


$adminSql = "SELECT * FROM `admins` WHERE `id` = $admin_id ";
$adminQuery = @$conn->query($adminSql);

$adminRow=mysqli_fetch_assoc($adminQuery);

if (empty($adminRow)){
    echo "<script>window.location.href = '/index.php';</script>";
} else {
    $adminFN = $adminRow["first_name"];
    $adminLN = $adminRow["last_name"];
}