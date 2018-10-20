<?php

require_once '../DB/studentDB.php';

$studentId = $_POST["Sid"];

$result = deleteStudent($studentId);

echo $result;
