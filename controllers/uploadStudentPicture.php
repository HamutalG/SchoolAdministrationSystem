<?php

$Student_Name = $_POST['Student_Name'];
if (isset($_FILES['Spicture'])) {
    $filePath = '../UserPics/' . basename($Student_Name . $_FILES['Spicture']['name']);
    if (move_uploaded_file($_FILES['Spicture']['tmp_name'], $filePath)) {
        echo $filePath;
    } else {
        echo "ERR";
    }
}else{
    copy("../UserPics/originalPics/no-user.png","../UserPics/$Student_Name.png");
    
    echo "../UserPics/$Student_Name.png";
}
