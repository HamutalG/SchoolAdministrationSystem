currentCourses = [];
studentCourses = [];
numOfStudents = 0;

function showStudents()
{
    $.getJSON("../controllers/studentController.php", function (students)
    {
        $(".studentList").html("");

        for (let i = 0; i < students.length; i++) {
            let student = students[i];
            var studentName = "<div class='studentInfo'><h3>" + student.Student_Name + "</h3></div>";
            var studentEmail = "<div name='Semail' class='studentInfo'><h5>" + student.Semail + "</h5></div>";
            var studentPhone = "<div class='studentInfo'><h5>" + student.Phone_Number + "</h5></div>";
            var studentPicture = "<div class='studentInfo'><img id='studentpic' src='" + student.Spicture + "'/></div>";
            var studentDiv = `<div class='eachStudent' data-Sid=${student.Sid}>` + studentName + studentPhone + studentEmail + studentPicture + "</div>";
            $(".studentList").append(studentDiv);
        }
    });
}

function totalNumOfStudents() {
    $.getJSON("../controllers/studentController.php", function (students)
    {
        numOfStudents = students.length;
        $("#innerChangeContA").html("<h1 class='totals'>There Are A Total Of " + numOfStudents + " Students</h1>");
    });
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imgToDisplay')
                    .attr('src', e.target.result)
                    .height(100);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL4(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imgToDisplayE')
                    .attr('src', e.target.result)
                    .height(100);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {

    $(".plusGlyph").click(function () {
        $('[name="Student_Name"]').val("");
        $('[name="Phone_Number"]').val("");
        $('[name="Semail"]').val("");
        $("#addCoursesToStudent").html("");
        $("#editCoursesForStudent").html("");

        $(".showOrHideEditDeleteStudentForm").css("display", "none");
        $(".showOrHideStudentInfo").css("display", "none");
        $(".showOrHideCourseInfo").css("display", "none");
        $(".showOrHideAddCourseForm").css("display", "none");
        $(".showOrHideEditDeleteCourseForm").css("display", "none");
        $("#innerChangeCont").css("display", "none");

        $(".showOrHideAddStudentForm").css("display", "block");

        setTimeout(function () {
            showCoursesforStudent();
        }, 200);

    });

    function showCoursesforStudent()
    {
        $.getJSON("../controllers/courseController.php", function (courses)
        {

            $(".addCoursesToStudent").html("");
            $("#editCoursesForStudent").html("");


            for (let i = 0; i < courses.length; i++) {
                let course = courses[i];
                var courseName = `<li><input type='checkbox' name="studentCourses[]" data-id=${course.course_id} id='${course.course_id}'/><label class='courseCheckboxes' for="${course.Course_Name}">${course.Course_Name}</label></li>`;
                $("#addCoursesToStudent").append(courseName);
            }
        });
    }

    function showCoursesforStudent2()
    {
        $.getJSON("../controllers/courseController.php", function (courses)
        {
            currentCourses = courses;

            $(".addCoursesToStudent").html("");
            $("#editCoursesForStudent").html("");

            for (let i = 0; i < courses.length; i++) {
                let course = courses[i];
                var courseName = `<li><input type='checkbox' name="studentCourses[]" data-id=${course.course_id} id='${course.course_id}'/><label class='courseCheckboxes' for="${course.Course_Name}">${course.Course_Name}</label></li>`;
                $("#editCoursesForStudent").append(courseName);
            }
        });

    }

    $(".studentList").on("click", ".eachStudent", function () {
        $(".innerStudentInfo").html("");
        $("#editCoursesForStudent").html("");
        $(".ScourseListItems").html("");
        $(".ScourseListItems").css("border-bottom", "none");

        $(".showOrHideAddStudentForm").css("display", "none");
        $(".showOrHideEditDeleteStudentForm").css("display", "none");
        $(".showOrHideCourseInfo").css("display", "none");
        $(".showOrHideAddCourseForm").css("display", "none");
        $(".showOrHideEditDeleteCourseForm").css("display", "none");
        $("#innerChangeCont").css("display", "none");

        $(".showOrHideStudentInfo").css("display", "block");

        $.post('../controllers/studentController.php', {Sid: $(this).data("sid"), state: 1}, function (data) {

            $studentInfo = JSON.parse(data);

            var editSBtn = `<input data-Sid='${($studentInfo.Sid)}' id='editSBtn' type='button' class='btn' name='Semail' value='Edit' />`;

            var stuName = "<div class='stuInfo'><h3>" + $studentInfo.Student_Name + "</h3></div><br/>";
            var stuPhone = "<div class='stuInfo'><h5>Phone Number: " + $studentInfo.Phone_Number + "</h5></div><br/>";
            var stuEmail = "<div class='stuInfo'><h5>Email: " + $studentInfo.Semail + "</h5></div><br/><br/>";
            var stuPicture = "<div class='stuInfo'><img id='studentpic' src='" + $studentInfo.Spicture + "'/></div>";
            var stuDiv = "<div class='eachStu'>" + editSBtn + stuName + stuPhone + stuEmail + stuPicture + "</div>";
            $(".innerStudentInfo").append(stuDiv);
            showStudentCourses($studentInfo.Sid);
        });
    });

    function showStudentCourses(Sid)
    {
        $.post("../controllers/studentController.php", {state: 2, Sid: Sid}, function (courses)
        {
            $(".ScourseListItems").html("");
            $(".ScourseListItems").css("border-bottom", "none");

            var parsedCourses = JSON.parse(courses);
            studentCourses = parsedCourses;

            for (let i = 0; i < parsedCourses.length; i++) {
                let course = parsedCourses[i];
                var ScourseName = "<h5 class='SCInfo'>Course Name: </h5>" + course.Course_Name + "<br/>";
                var ScourseDescription = "<h5 class='SCInfo'>Course Description: </h5>" + course.description + "<br/>";
                var ScoursePicture = "<img id='courseOfStudentPics' src='" + course.Cpicture + "'/>" + "<br/>";
                var ScourseList = "<li class='col-sm-12 ScourseListItems'>" + ScourseName + ScourseDescription + ScoursePicture + "</li>";
                $("#coursesOfStudent").append(ScourseList);
            }
        });
    }

    $(".innerStudentInfo").on("click", "#editSBtn", function () {

        $(".showOrHideAddStudentForm").css("display", "none");
        $(".showOrHideStudentInfo").css("display", "none");
        $(".showOrHideCourseInfo").css("display", "none");
        $(".showOrHideAddCourseForm").css("display", "none");
        $(".showOrHideEditDeleteCourseForm").css("display", "none");
        $("#innerChangeCont").css("display", "none");
        $("#editCoursesForStudent").html("");

        $(".showOrHideEditDeleteStudentForm").css("display", "block");

        $.post('../controllers/studentController.php', {Sid: $(this).data("sid"), state: 1}, function (data) {

            $studentInfo = JSON.parse(data);

            $('[name="Student_Name"]').val($studentInfo.Student_Name);
            $('[name="Phone_Number"]').val($studentInfo.Phone_Number);
            $('[name="Semail"]').val($studentInfo.Semail);
            $('#imgToDisplayE').attr("src", $studentInfo.Spicture);

            $('#dltSBtn').data("sid", $studentInfo.Sid);
            $('#editStuBtn').data("sid", $studentInfo.Sid);

            showCoursesforStudent2();

            setTimeout(function () {

                for (let i = 0; i < studentCourses.length; i++) {
                    for (let x = 0; x < currentCourses.length; x++) {
                        if (currentCourses[x].course_id == studentCourses[i].course_id) {
                            $(`#${currentCourses[x].course_id}`).attr('checked', true);
                            console.log($(`#${currentCourses[x].Course_Name}`));

                        }
                    }
                }
            }, 200);
        });
    });

    $("#addStudentForm").on("click", "#saveBtn", function () {
        var Student_Name = $('[name="Student_Name"]').val();
        var Phone_Number = $('[name="Phone_Number"]').val();
        var Semail = $('#addSEmail').val();
        var Spicture = document.getElementsByName("Spicture")[0].files[0];
        var checkedCourses = [];

        $("[name='studentCourses[]']:checked").each(function () {
            let id = $(this).data("id");
            checkedCourses.push(id);
        });

        var myFormData = new FormData();
        myFormData.append('Spicture', Spicture, '.png');
        myFormData.append('Student_Name', Student_Name);


        $.ajax({
            url: '../controllers/uploadStudentPicture.php',
            data: myFormData,
            type: 'POST',
            success: function (data) {
                saveStudent(Student_Name, Phone_Number, Semail, data, checkedCourses);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    function saveStudent(Student_Name, Phone_Number, Semail, Spicture, checkedCourses)
    {
        $.post("../controllers/studentAdd.php", {Student_Name: Student_Name, Phone_Number: Phone_Number, Semail: Semail, Spicture: Spicture, checkedCourses: JSON.stringify(checkedCourses)},
                function (data) {

                    if (data === "success") {
                        $("#addStudentForm")[0].reset();
                        $("#imgToDisplay").attr("src", "");
                        $("#imgToDisplay").css("height", "");
                        console.log("Student added successfully!");

                        $(".studentList").html("");
                        $(".showOrHideAddStudentForm").css("display", "none");
                        $("#innerChangeCont").css("display", "block");
                        showStudents();
                        showCourses();
                        totalNumOfStudents();
                        totalNumOfCourses();
                    } else {
                        console.log("There was an error adding the student.");
                    }
                });
    }

    $("#editStuBtn").click(function () {

        var Student_Name = $('#editStuName').val();
        var Phone_Number = $('#editStuPhone').val();
        var Semail = $('#updateDeleteSEmail').val();
        var Spicture = document.getElementsByName("SEpicture")[0].files[0];
        var Sid = $(this).data("sid");

        var myFormData = new FormData();
        myFormData.append('Spicture', Spicture, '.png');
        myFormData.append('Student_Name', Student_Name);
        debugger;
        $.ajax({
            url: '../controllers/uploadStudentPicture.php',
            data: myFormData,
            type: 'POST',
            success: function (data) {
                updateStudent(Sid, Student_Name, Phone_Number, Semail, data);
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });

    function updateStudent(Sid, Student_Name, Phone_Number, Semail, Spicture)
    {

        $.post("../controllers/studentUpdate.php", {Sid: Sid, Student_Name: Student_Name, Phone_Number: Phone_Number, Semail: Semail, Spicture: Spicture},
                function (data) {

                    if (data === "success") {
                        $("#EditDeleteStudentForm")[0].reset();
                        $("#imgToDisplayE").css("display", "none");
                        console.log("Student updated successfully!");

                        $(".studentList").html("");
                        $(".showOrHideEditDeleteStudentForm").css("display", "none");
                        $("#innerChangeCont").css("display", "block");
                        showStudents();
                        showCourses();
                        totalNumOfStudents();
                        totalNumOfCourses();

                    } else {
                        console.log("There was an error updating the student.");
                    }
                });
    }

    $("#dltSBtn").click(function () {

        $.post("../controllers/studentDelete.php", {Sid: $(this).data("sid")}, function (data) {

            if (data === "success") {
                $("#EditDeleteStudentForm")[0].reset();
                $("#imgToDisplay").attr("src", "");
                $("#imgToDisplay").css("height", "");
                console.log("Student deleted successfully!");

                $(".studentList").html("");
                $(".showOrHideEditDeleteStudentForm").css("display", "none");
                $("#innerChangeCont").css("display", "block");
                showStudents();
                showCourses();
                totalNumOfStudents();
                totalNumOfCourses();

            } else {
                console.log("There was an error deleting the student.");
            }
        });
    });
}
);



