<?php

class User {

    public $admin_id;
    public $User_Name;
    public $password;
    public $email;
    public $Phone_Number;
    public $role;
    public $picture;

    function __construct($User_Name, $password, $email, $Phone_Number, $role, $picture) {
        $this->User_Name = $User_Name;
        $this->password = $password;
        $this->email = $email;
        $this->Phone_Number = $Phone_Number;
        $this->role = $role;
        $this->picture = $picture;
    }

    function getName() {
        return $this->User_Name;
    }
    
    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone_Number() {
        return $this->Phone_Number;
    }

    function getRole() {
        return $this->role;
    }

    function getPicture() {
        return $this->picture;
    }

    function setName($User_Name) {
        $this->User_Name = $User_Name;
    }
    
    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone_Number($Phone_Number) {
        $this->Phone_Number = $Phone_Number;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setPicture($picture) {
        $this->picture = $picture;
    }

}
