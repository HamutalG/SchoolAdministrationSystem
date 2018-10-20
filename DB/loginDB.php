<?php

session_start();

require_once '../DB/connection.php';
require_once '../models/user.php';

function checkLogin($userName, $password) {

    $sql = "SELECT count(*) AS total FROM users WHERE email = '$userName'";
    $result = $GLOBALS['conn']->query($sql);
    $row = $result->fetch_assoc();

    if ($row["total"] < 1) {

        return "Incorrect Username!";
    } else {
        $sql = "SELECT count(*) AS total FROM users WHERE password = '$password' AND email = '$userName'";
        $result = $GLOBALS['conn']->query($sql);
        $row = $result->fetch_assoc();

        if ($row["total"] > 0) {
            $sql = "SELECT * FROM users WHERE password = '$password' AND email = '$userName'";
            $result = $GLOBALS['conn']->query($sql);
            $row = $result->fetch_assoc();

            $myUser = new User($row['User_Name'], $row['password'], $row['email'], $row['Phone_Number'], $row['role'], $row['picture']);

            if ($myUser->role == "Owner") {
                $_SESSION['Owner'] = serialize($myUser);       
            } else if ($myUser->role == "Sales") {
                $_SESSION['Sales'] = serialize($myUser);  
            } else if ($myUser->role == "Manager") {
                $_SESSION['Manager'] = serialize($myUser);
            }
            return "1";
        } else {
            return "Incorrect Password!";
        }
    }
    $GLOBALS['conn']->close();
}
