<?php

require_once '../DB/courseDB.php';
require_once '../models/course.php';

$Course_Name = $_POST['Course_Name'];
$description = $_POST['description'];
$Cpicture = $_POST['CCurrentImg'];

if (isset($_FILES['Cpicture'])) {
    $image = $_FILES['Cpicture'];
    $img = updateCourseImg($Cpicture, $image);
}

function updateCourseImg($Cpicture, $image) {
    $file = basename($Cpicture, ".png");
    $root = '../UserPics/' .$file.".png";
    if (move_uploaded_file($image['tmp_name'], $root)) {
        return $root;
    } else {
        return "ERR";
    }
}

$course1 = new Course($Course_Name, $description, $Cpicture);
$course1->course_id = $_POST['course_id']; 

$result = editCourse($course1);

echo $result;