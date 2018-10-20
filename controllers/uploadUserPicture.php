<?php


$User_Name = $_POST['User_Name'];
if (isset($_FILES['picture'])) {
    $filePath = '../UserPics/' . basename($User_Name . $_FILES['picture']['name']);
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $filePath)) {
        echo $filePath;
    } else {
        echo "ERR";
    }
}else{
    copy("../UserPics/originalPics/no-user.png","../UserPics/$User_Name.png");
    
    echo "../UserPics/$User_Name.png";
}