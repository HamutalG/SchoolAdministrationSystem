<?php

$Course_Name = $_POST['Course_Name'];
if (isset($_FILES['Cpicture'])) {
    $filePath = '../UserPics/' . basename($Course_Name . $_FILES['Cpicture']['name']);
    if (move_uploaded_file($_FILES['Cpicture']['tmp_name'], $filePath)) {
        echo $filePath;
    } else {
        echo "ERR";
    }
}else{
    copy("../UserPics/originalPics/no-course.png","../UserPics/$Course_Name.png");
    
    echo "../UserPics/$Course_Name.png";
}
