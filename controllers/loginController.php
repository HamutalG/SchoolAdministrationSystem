<?php

require_once '../DB/loginDB.php';

$userName = $_POST["name"];
$password = sha1($_POST["password"]);

$userDetails = checkLogin($userName, $password);

echo $userDetails;