<?php

require '../DB/courseDB.php';

if (isset($_POST['state'])) {
    if ($_POST['state'] == 1) {
        $course = $_POST['course_id'];
        echo json_encode(getCourseDetails($course));
    } else {

        if ($_POST['state'] == 2) {
            $courseId = $_POST['course_id'];
            echo json_encode(getCourseStudents($courseId));
        }
    }
} else {
    $allCoursesArr = getAllCourses();

    $myJSON = json_encode($allCoursesArr);

    echo $myJSON;
}