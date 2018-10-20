<?php

require_once '../DB/studentDB.php';
require_once '../models/student.php';

$Student_Name = $_POST['Student_Name'];
$Phone_Number = $_POST['Phone_Number'];
$Semail = $_POST['Semail'];
$Spicture = $_POST['currentSImg'];
$coursesArr = json_decode($_POST['checkedCourses']);


if (isset($_FILES['Spicture'])) {
    $image = $_FILES['Spicture'];
    $img = updateStudentImg($Spicture, $image);
}

function updateStudentImg($Spicture, $image) {
    $file = basename($Spicture, ".png");
    $root = '../UserPics/' .$file.".png";
    if (move_uploaded_file($image['tmp_name'], $root)) {
        return $root;
    } else {
        return "ERR";
    }
}


$student1 = new Student($Student_Name, $Phone_Number, $Semail, $Spicture);
$student1->Sid = $_POST['Sid']; 

$result = editStudent($student1, $coursesArr);

echo $result;

