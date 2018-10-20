<?php

class Course {

    public $course_id;
    public $Course_Name;
    public $description;
    public $Cpicture;

    function __construct($Course_Name, $description, $Cpicture) {
        $this->Course_Name = $Course_Name;
        $this->description = $description;
        $this->Cpicture = $Cpicture;
    }

    function getCName() {
        return $this->Course_Name;
    }

    function getDescription() {
        return $this->description;
    }

    function getCpicture() {
        return $this->Cpicture;
    }

    function setCName($Course_Name) {
        $this->Course_Name = $Course_Name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setCpicture($Cpicture) {
        $this->Cpicture = $Cpicture;
    }

}
