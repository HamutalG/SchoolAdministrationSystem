<?php

class Student {

    public $Student_Name;
    public $Phone_Number;
    public $Semail;
    public $Spicture;
    public $Sid;

    function __construct($Student_Name, $Phone_Number, $Semail, $Spicture) {
        $this->Student_Name = $Student_Name;
        $this->Phone_Number = $Phone_Number;
        $this->Semail = $Semail;
        $this->Spicture = $Spicture;
    }

    function getSName() {
        return $this->Student_Name;
    }

    function getPhone_Number() {
        return $this->Phone_Number;
    }

    function getSemail() {
        return $this->Semail;
    }

    function getSpicture() {
        return $this->Spicture;
    }

    function setSName($Student_Name) {
        $this->Student_Name = $Student_Name;
    }

    function setPhone_Number($Phone_Number) {
        $this->Phone_Number = $Phone_Number;
    }

    function setSemail($Semail) {
        $this->Semail = $Semail;
    }

    function setSpicture($Spicture) {
        $this->Spicture = $Spicture;
    }

}
