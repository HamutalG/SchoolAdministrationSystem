<?php

require_once 'connection.php';
require_once '../models/course.php';
require_once '../models/student.php';

function getAllCourses() {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT * FROM courses;";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {

        $allCoursesArr = array();

        while ($row = $result->fetch_assoc()) {
            $course = new Course($row ["Course_Name"], $row ["description"], $row ["Cpicture"]);
            $course->course_id = $row['ID'];

            array_push($allCoursesArr, $course);
        }
    } else {
        echo "0 results";
    }

    return $allCoursesArr;
}

function addCourse($course1) {
    $conn = $GLOBALS['conn'];

    $stmt = $conn->prepare("INSERT INTO courses (Course_Name, description, Cpicture) VALUES (?,?,?)");
    $stmt->bind_param("sss", $course1->Course_Name, $course1->description, $course1->Cpicture);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();

    if ($stmt) {
        return 'success';
    } else {
        return 'failed';
    }
}

function deleteCourse($courseId) {
    require_once '../controllers/courseDelete.php';

    $conn = $GLOBALS['conn'];

    $sql = "DELETE FROM courses WHERE ID ='$courseId'";
    $result = $conn->query($sql);

    $sql = "DELETE FROM studentsandcourses WHERE Course_ID = '$courseId'";
    $result = $conn->query($sql);

    $conn->close();

    if ($result) {
        return 'success';
    } else {
        return 'failed';
    }
}

function editCourse($course1) {

    $conn = $GLOBALS['conn'];

    $sql = "UPDATE courses SET Course_Name = '$course1->Course_Name'  , description= '$course1->description' , Cpicture = '$course1->Cpicture' WHERE ID= '$course1->course_id'";
    $result = $conn->query($sql);

    $conn->close();

    if ($result) {
        return 'success';
    } else {
        return 'failed';
    }
}

function getCourseDetails($course) {
    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM courses WHERE ID = '$course'";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    $course = new Course($row ["Course_Name"], $row ["description"], $row["Cpicture"]);
    $course->course_id = $row['ID'];
    
    $conn->close();

    if ($result) {
        return $course;
    } else {
        return 'failed';
    }
}

function getCourseStudents($courseId) {
    $conn = $GLOBALS['conn'];
    $courseStudentsArr = [];
    $studentsArr = [];
    $sql = "SELECT * FROM studentsandcourses WHERE Course_ID = $courseId";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $studentID = $row['Student_ID'];
        array_push($courseStudentsArr, $studentID);
    }

    foreach ($courseStudentsArr as $studentId) {
        $sql = "SELECT * FROM students WHERE ID = $studentId";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $oneStudent = new Student($row['Student_Name'], $row['Phone_Number'], $row['Semail'], $row['Spicture']);
        $oneStudent->student_id = $row['ID'];
        array_push($studentsArr, $oneStudent);
    }

    $conn->close();
    return $studentsArr;
}
