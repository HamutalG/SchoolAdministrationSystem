<?php

require_once '../models/course.php';
require_once '../DB/courseDB.php';

$Course_Name = $_POST['Course_Name'];
$description = $_POST['description'];
$Cpicture = $_POST['Cpicture'];

$course1 = new Course($Course_Name, $description, $Cpicture);

$result = addCourse($course1);

echo $result;
