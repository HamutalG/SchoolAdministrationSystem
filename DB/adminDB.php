<?php

require_once 'connection.php';
require_once '../models/user.php';

function getAllAdmin() {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT * FROM users;";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {

        $allUsersArr = array();

        while ($row = $result->fetch_assoc()) {
            $user = new User($row ["User_Name"], $row ["password"], $row ["email"], $row ["Phone_Number"], $row ["role"], $row["picture"]);
            $user->admin_id = $row['ID'];
            
            array_push($allUsersArr, $user);
        }
    } else {
        echo "0 results";
    }

    return $allUsersArr;
}

function addUser($user1) {
    $conn = $GLOBALS['conn'];

    $stmt = $conn->prepare("INSERT INTO users (User_Name, password, email, Phone_Number, role, picture) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $user1->User_Name, $user1->password, $user1->email, $user1->Phone_Number, $user1->role, $user1->picture);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    if ($stmt) {
        return 'success';
    } else {
        return 'failed';
    }
}

function deleteAdmin($adminId) {
    require_once '../controllers/adminDelete.php';

    $conn = $GLOBALS['conn'];

    $sql = "DELETE FROM users WHERE ID ='$adminId'";
    $result = $conn->query($sql);

    $conn->close();

    if ($result) {
        return 'success';
    } else {
        return 'failed';
    }
}

function editUser($user1) {

    $conn = $GLOBALS['conn'];

    $sql = "UPDATE users SET User_Name = '$user1->User_Name'  , password= '$user1->password' , email=  '$user1->email' , Phone_Number=  '$user1->Phone_Number', role= '$user1->role', picture = '$user1->picture' WHERE ID= '$user1->admin_id'";
    $result = $conn->query($sql);

    $conn->close();

    if ($result) {
        return 'success';
    } else {
        return 'failed';
    }
}

function getAdminDetails($adminId) {
    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM users WHERE ID = '$adminId'";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    $user = new User($row ["User_Name"], $row ["password"], $row ["email"], $row ["Phone_Number"], $row ["role"], $row["picture"]);
    $user->admin_id = $row['ID'];
    
    $conn->close();

    if ($result) {
        return $user;
    } else {
        return 'failed';
    }
}

function emailExistCheck($email) {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT count(*) AS total FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        return true;
    } else {
        return false;
    }
}