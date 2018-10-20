<?php

require_once 'connection.php';
require_once '../models/student.php';
require_once '../models/course.php';

function getAllStudents() {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT * FROM students;";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {

        $allStudentsArr = array();

        while ($row = $result->fetch_assoc()) {
            $student = new Student($row ["Student_Name"], $row ["Phone_Number"], $row ["Semail"], $row ["Spicture"]);
            $student->Sid = $row['ID'];

            array_push($allStudentsArr, $student);
        }
    } else {
        echo "0 results";
    }

    return $allStudentsArr;
}

function addStudent($student1, $coursesArr) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("INSERT INTO students (Student_Name, Phone_Number, Semail, Spicture) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $student1->Student_Name, $student1->Phone_Number, $student1->Semail, $student1->Spicture);
    $stmt->execute();

    $sql = "SELECT * FROM students ORDER BY ID DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $studentID = $row['ID'];
    foreach ($coursesArr as $courseID) {
        $sql = "INSERT INTO studentsandcourses (Student_ID,Course_ID) VALUES ($studentID,$courseID)";
        $result = $conn->query($sql);
    }

    $stmt->close();
    $conn->close();

    if ($stmt) {
        return 'success';
    } else {
        return 'failed';
    }
}

function deleteStudent($studentId) {
    require_once '../controllers/studentDelete.php';

    $conn = $GLOBALS['conn'];

    $sql = "DELETE FROM students WHERE ID ='$studentId'";
    $result = $conn->query($sql);

    $sql = "DELETE FROM studentsandcourses WHERE Student_ID = '$studentId'";
    $result = $conn->query($sql);

    $conn->close();

    if ($result) {
        return 'success';
    } else {
        return 'failed';
    }
}

function editStudent($student1, $coursesArr) {

    $conn = $GLOBALS['conn'];

    $sql = "UPDATE students SET Student_Name = '$student1->Student_Name'  , Phone_Number= '$student1->Phone_Number' , Semail=  '$student1->Semail' , Spicture = '$student1->Spicture' WHERE ID= '$student1->Sid'";
    $result = $conn->query($sql);

    $sql = "SELECT * FROM students WHERE ID = '$student1->Sid'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $sql = "DELETE FROM studentsandcourses WHERE Student_ID = '$student1->Sid'";
    $result = $conn->query($sql);

    $studentID = $row['ID'];
    foreach ($coursesArr as $courseID) {
        $sql = "INSERT INTO studentsandcourses (Student_ID,Course_ID) VALUES ($studentID,$courseID)";
        $result = $conn->query($sql);
    }

    $conn->close();

    if ($result) {
        return 'success';
    } else {
        return 'failed';
    }
}

function getStudentDetails($studentId) {
    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM students WHERE ID = $studentId";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    $student = new Student($row ["Student_Name"], $row ["Phone_Number"], $row ["Semail"], $row["Spicture"]);
    $student->Sid = $row['ID'];
    $conn->close();

    if ($result) {
        return $student;
    } else {
        return 'failed';
    }
}

function getStudentCourses($studentId) {
    $conn = $GLOBALS['conn'];
    $studentCoursesArr = [];
    $coursesArr = [];
    $sql = "SELECT * FROM studentsandcourses WHERE Student_ID = $studentId";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $courseID = $row['Course_ID'];
        array_push($studentCoursesArr, $courseID);
    }

    foreach ($studentCoursesArr as $courseId) {
        $sql = "SELECT * FROM courses WHERE ID = $courseId";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $oneCourse = new Course($row['Course_Name'], $row['description'], $row['Cpicture']);
        $oneCourse->course_id = $row['ID'];
        array_push($coursesArr, $oneCourse);
    }


    $conn->close();
    return $coursesArr;
}

function SemailExistCheck($Semail) {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT count(*) AS total FROM students WHERE Semail = '$Semail'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        return true;
    } else {
        return false;
    }
}
