<?php

require_once '../DB/courseDB.php';

$courseId = $_POST["course_id"];

$result = deleteCourse($courseId);

echo $result;
