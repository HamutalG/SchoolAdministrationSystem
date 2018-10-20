<?php

require_once '../DB/adminDB.php';
require_once '../models/user.php';

$User_Name = $_POST['User_Name'];
$password = sha1($_POST['password']);
$email = $_POST['email'];
$Phone_Number = $_POST['Phone_Number'];
$role = $_POST['role'];
$picture = $_POST['currentaimg'];

if (isset($_FILES['picture'])) {
    $image = $_FILES['picture'];
    $img = updateAdminImg($picture, $image);
}

function updateAdminImg($picture, $image) {
    $file = basename($picture, ".png");
    $root = '../UserPics/' .$file.".png";
    if (move_uploaded_file($image['tmp_name'], $root)) {
        return $root;
    } else {
        return "ERR";
    }
}

$user1 = new User($User_Name, $password, $email, $Phone_Number, $role, $picture);
$user1->admin_id = $_POST['admin_id']; 

$result = editUser($user1);

echo $result;
