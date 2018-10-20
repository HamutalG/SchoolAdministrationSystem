<?php

require_once '../models/user.php';
require_once '../DB/adminDB.php';

$User_Name = $_POST['User_Name'];
$password = sha1($_POST['password']);
$email = $_POST['email'];
$Phone_Number = $_POST['Phone_Number'];
$role = $_POST['role'];
$picture = $_POST['picture'];

$user1 = new User($User_Name, $password, $email, $Phone_Number, $role, $picture);

$result = addUser($user1);

echo $result;



