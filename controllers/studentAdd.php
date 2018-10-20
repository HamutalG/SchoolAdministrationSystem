<?php

require_once '../models/student.php';
require_once '../DB/studentDB.php';

$Student_Name = $_POST['Student_Name'];
$Phone_Number = $_POST['Phone_Number'];
$Semail = $_POST['Semail'];
$Spicture = $_POST['Spicture'];
$coursesArr = json_decode($_POST['checkedCourses']);

$studednt1 = new Student($Student_Name, $Phone_Number, $Semail, $Spicture);

$result = addStudent($studednt1,$coursesArr);

echo $result;
