<?php

require_once '../DB/adminDB.php';

$adminId = $_POST["admin_id"];

$result = deleteAdmin($adminId);

echo $result;

