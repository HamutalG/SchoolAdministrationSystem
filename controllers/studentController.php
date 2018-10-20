<?php

require '../DB/studentDB.php';

if (isset($_POST['state'])) {
    if ($_POST['state'] == 1) {
        $studentId = $_POST['Sid'];
        echo json_encode(getStudentDetails($studentId));
    } else {

        if ($_POST['state'] == 2) {
            $studentId = $_POST['Sid'];
            echo json_encode(getStudentCourses($studentId));
        }
        
        if ($_POST['state'] == 3) {
            $Semail = $_POST['Semail'];
            echo SemailExistCheck($Semail);
        }
    }
} else {
    $allStudentsArr = getAllStudents();

    $myJSON = json_encode($allStudentsArr);

    echo $myJSON;
}