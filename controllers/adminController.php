<?php

require '../DB/adminDB.php';

if (isset($_POST['state'])) {
    if ($_POST['state'] == 1) {
        $adminId = $_POST['admin_id'];
        echo json_encode(getAdminDetails($adminId));
    } else {
        if ($_POST['state'] == 3) {
            $email = $_POST['email'];
            echo emailExistCheck($email);
        }
    }
} else {
    $allUsersArr = getAllAdmin();

    $myJSON = json_encode($allUsersArr);

    echo $myJSON;
}