
<!DOCTYPE html>
<html>
    <head>
        <title>School</title>
        <!--There is a JS folder with separated JS files. 
            JS is also here for the required validations in PHP -->
        <script>

            //Student JS

            currentCourses = [];
            studentCourses = [];
            numOfStudents = 0;
            eachCourseNumS = 0;

            //creates the student divs on the left side list
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

            //shows total number of students in the "changing container"
            function totalNumOfStudents() {
                $.getJSON("../controllers/studentController.php", function (students)
                {
                    numOfStudents = students.length;
                    $("#innerChangeContA").html("<h1 class='totals'>There Are A Total Of " + numOfStudents + " Students</h1>");
                });
            }

            //shows preview of picture on the "add student" form
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

            //shows preview of picture on the "edit or delete student" form
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

                //to reach the add new student form
                $(".plusGlyph").click(function () {
                    $('[name="Student_Name"]').val("");
                    $('[name="Phone_Number"]').val("");
                    $('#addSEmail').val("");
                    $('#addSEmail').blur(function () {
                        SemailExist($('#addSEmail').val());
                    });
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

                //show course options when adding a new student
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

                //shows chosen courses when editing a student
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

                //show student information
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

                        var editSBtn = `<input data-currentsimg = '${($studentInfo.Spicture)}' data-Sid='${($studentInfo.Sid)}' id='editSBtn' type='button' class='btn' name='Semail' value='Edit' />`;

                        var stuName = "<div class='stuInfo'><h3>" + $studentInfo.Student_Name + "</h3></div><br/>";
                        var stuPhone = "<div class='stuInfo'><h5>Phone Number: " + $studentInfo.Phone_Number + "</h5></div><br/>";
                        var stuEmail = "<div class='stuInfo'><h5>Email: " + $studentInfo.Semail + "</h5></div><br/><br/>";
                        var stuPicture = "<div class='stuInfo'><img id='studentpic' src='" + $studentInfo.Spicture + "'/></div>";
                        var stuDiv = "<div class='eachStu'>" + editSBtn + stuName + stuPhone + stuEmail + stuPicture + "</div>";
                        $(".innerStudentInfo").append(stuDiv);
                        showStudentCourses($studentInfo.Sid);

                    });
                });

                //show what courses the student is taking in the student information view
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

                //click the "edit" button in student info view to reach the "edit" student view
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
                        $('#updateDeleteSEmail').blur(function () {
                            SemailExist2($('#updateDeleteSEmail').val());
                        });
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

                //check if email exists when adding a new student
                function SemailExist(Semail) {

                    $.post("../controllers/studentController.php", {Semail: Semail, state: 3}
                    ,
                            function (data) {

                                if (data) {
                                    $("#emailError").show();
                                    $("#emailError").html("<h6>'Email already exists in the system'</h6>")
                                } else if (!data) {
                                    $("#emailError").hide();
                                }
                            });
                }

                //check if email exists when editing a student
                function SemailExist2(Semail) {

                    $.post("../controllers/studentController.php", {Semail: Semail, state: 3}
                    ,
                            function (data) {

                                if (data) {
                                    $("#editSemailError").show();
                                    $("#editSemailError").html("<h6>'Email already exists in the system'</h6>")
                                } else if (!data) {
                                    $("#editSemailError").hide();
                                }
                            });
                }

                //clicking "save" after adding a new student to the system
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

                //(continuation) saving a new student to the system 
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

                //clicking "save" after editing student info
                $("#editStuBtn").click(function () {

                    var Student_Name = $('#editStuName').val();
                    var Phone_Number = $('#editStuPhone').val();
                    var Semail = $('#updateDeleteSEmail').val();
                    var Spicture = document.getElementsByName("SEpicture")[0].files[0];
                    var SCurrentImg = $("#editSBtn").data("currentsimg");
                    var Sid = $(this).data("sid");
                    var checkedCourses = [];

                    $("[name='studentCourses[]']:checked").each(function () {
                        let id = $(this).data("id");
                        checkedCourses.push(id);
                    });

                    var myFormData = new FormData();
                    myFormData.append('Spicture', Spicture, '.png');
                    myFormData.append('Student_Name', Student_Name);
                    myFormData.append('Phone_Number', Phone_Number);
                    myFormData.append('Semail', Semail);
                    myFormData.append('currentSImg', SCurrentImg);
                    myFormData.append('checkedCourses', JSON.stringify(checkedCourses));
                    myFormData.append('Sid', Sid);

                    $.ajax({
                        url: '../controllers/studentUpdate.php',
                        data: myFormData,
                        type: 'POST',
                        success: function (data) {

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
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                });

                //deleting a student from the system
                $("#dltSBtn").click(function () {

                    var deleteConfirm = confirm("Are you sure you want to delete permenantly from the system?");

                    if (deleteConfirm) {
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
                    }
                });
            });

            //Courses JS

            numOfCourses = 0;

            //creates the courses divs on the left side list
            function showCourses()
            {
                $.getJSON("../controllers/courseController.php", function (courses)
                {

                    $(".coursesList").html("");

                    for (let i = 0; i < courses.length; i++) {
                        let course = courses[i];
                        var courseName = "<div class='courseInfo'><h3>" + course.Course_Name + "</h3></div>";
                        var courseDescription = "<div name='description' class='courseInfo'><h5>" + course.description + "</h5></div>";
                        var coursePicture = "<div class='courseInfo'><img id='coursePic' src='" + course.Cpicture + "'/></div>";
                        var courseDiv = `<div class='eachCourse' data-course_id='${course.course_id}'>` + courseName + courseDescription + coursePicture + "</div>";
                        $(".coursesList").append(courseDiv);
                    }
                });
            }

            //shows total number of courses in the "changing container"
            function totalNumOfCourses() {
                $.getJSON("../controllers/courseController.php", function (courses)
                {
                    numOfCourses = courses.length;
                    $("#innerChangeContB").html("<h1 class='totals'>And A Total Of " + numOfCourses + " Courses</h1>");
                });
            }

            //preview of course picture when adding a new course
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#CimgToDisplay')
                                .attr('src', e.target.result)
                                .height(100);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            //preview of course picture when editing a coure
            function readURL1(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#CimgToDisplayE')
                                .attr('src', e.target.result)
                                .height(100);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(document).ready(function () {

                //to reach the add a new course form
                $(".plusCGlyph").click(function () {
                    $('[name="Course_Name"]').val("");
                    $('[name="description"]').val("");

                    $(".showOrHideEditDeleteStudentForm").css("display", "none");
                    $(".showOrHideStudentInfo").css("display", "none");
                    $(".showOrHideCourseInfo").css("display", "none");
                    $(".showOrHideAddStudentForm").css("display", "none");
                    $(".showOrHideEditDeleteCourseForm").css("display", "none");
                    $("#innerChangeCont").css("display", "none");

                    $(".showOrHideAddCourseForm").css("display", "block");
                });

                if ("<?php echo currentRole ?>" == "Sales") {
                    $('.plusCGlyph').hide();
                }

                //shows course info
                $(".coursesList").on("click", ".eachCourse", function () {
                    $(".innerCourseInfo").html("");
                    $(".CStudentListItems").html("");
                    $(".CStudentListItems").css("border-bottom", "none");

                    $(".showOrHideAddStudentForm").css("display", "none");
                    $(".showOrHideEditDeleteStudentForm").css("display", "none");
                    $(".showOrHideStudentInfo").css("display", "none");
                    $(".showOrHideAddCourseForm").css("display", "none");
                    $(".showOrHideEditDeleteCourseForm").css("display", "none");
                    $("#innerChangeCont").css("display", "none");

                    $(".showOrHideCourseInfo").css("display", "block");

                    $.post('../controllers/courseController.php', {course_id: $(this).data("course_id"), state: 1}, function (data) {

                        $courseInfo = JSON.parse(data);

                        var editCourseBtn = `<input data-currentcimg = '${($courseInfo.Cpicture)}' data-course_id='${($courseInfo.course_id)}' id='editCourseBtn' type='button' class='btn' name='course' value='Edit' />`;

                        var courName = "<div class='courInfo'><h3>" + $courseInfo.Course_Name + "</h3></div>";
                        var courDescription = "<div class='courInfo desc'><h5>Description: " + $courseInfo.description + "</h5></div><br/>";
                        var courPicture = "<div class='courInfo'><img id='coursePic' src='" + $courseInfo.Cpicture + "'/></div>";
                        var courDiv = "<div class='eachCour'>" + editCourseBtn + courName + courDescription + courPicture + "</div>";
                        $(".innerCourseInfo").append(courDiv);
                        showNumOfStudents($courseInfo.course_id);

                        if ("<?php echo currentRole ?>" == "Sales") {
                            $('#editCourseBtn').hide();
                        }



                    });
                });

                //shows what students are taking the course
                function showNumOfStudents(course_id)
                {
                    $.post("../controllers/courseController.php", {state: 2, course_id: course_id}, function (students)
                    {
                        $(".CStudentListItems").html("");
                        $(".CStudentListItems").css("border-bottom", "none");

                        var parsedStudents = JSON.parse(students);
                        eachCourseNumS = parsedStudents.length;

                        for (let i = 0; i < parsedStudents.length; i++) {
                            let student = parsedStudents[i];
                            var CStudentName = "<h5 class='SCInfo'>Student Name: </h5>" + student.Student_Name + "<br/><br/>";
                            var CStudentPicture = "<img id='courseOfStudentPics' src='" + student.Spicture + "'/>" + "<br/>";
                            var CStudentList = "<li class='col-sm-12 CStudentListItems'>" + CStudentName + CStudentPicture + "</li>";
                            $("#studentsOfCourse").append(CStudentList);
                        }
                    });
                }

                //click the "edit" button in course info view to reach the "edit" course view
                $(".innerCourseInfo").on("click", "#editCourseBtn", function () {

                    $(".showOrHideAddStudentForm").css("display", "none");
                    $(".showOrHideStudentInfo").css("display", "none");
                    $(".showOrHideCourseInfo").css("display", "none");
                    $(".showOrHideAddCourseForm").css("display", "none");
                    $(".showOrHideEditDeleteStudentForm").css("display", "none");
                    $("#innerChangeCont").css("display", "none");

                    $(".showOrHideEditDeleteCourseForm").css("display", "block");
                    $("#dltBtn").data("showNumOfStudents", $("#editCourseBtn").data("showNumOfStudents"));

                    $.post('../controllers/courseController.php', {course_id: $(this).data("course_id"), state: 1}, function (data) {

                        $courseInfo = JSON.parse(data);

                        $('[name="Course_Name"]').val($courseInfo.Course_Name);
                        $('[name="description"]').val($courseInfo.description);
                        $('#CimgToDisplayE').attr("src", $courseInfo.Cpicture);

                        $('#dltCBtn').data("course_id", $courseInfo.course_id);
                        $('#editCBtn').data("course_id", $courseInfo.course_id);
                    });
                });

                //add a new course to the system
                $("#saveCBtn").click(function () {

                    var Course_Name = $('[name="Course_Name"]').val();
                    var description = $('#addDescr').val();
                    var Cpicture = document.getElementsByName("Cpicture")[0].files[0];
                    var course_id = $(this).data("course_id");

                    var myFormData = new FormData();
                    myFormData.append('Cpicture', Cpicture, '.png');
                    myFormData.append('Course_Name', Course_Name);

                    $.ajax({
                        url: '../controllers/uploadCoursePicture.php',
                        data: myFormData,
                        type: 'POST',
                        success: function (data) {
                            saveCourse(course_id, Course_Name, description, data);
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                });

                //(continuation) add a new course
                function saveCourse(course_id, Course_Name, description, Cpicture)
                {

                    $.post("../controllers/courseAdd.php", {course_id: course_id, Course_Name: Course_Name, description: description, Cpicture: Cpicture},
                            function (data) {

                                if (data === "success") {
                                    $("#addCourseForm")[0].reset();
                                    $("#CimgToDisplay").attr("src", "");
                                    $("#CimgToDisplay").css("height", "");
                                    console.log("Course added successfully!");

                                    $(".coursesList").html("");
                                    $(".showOrHideAddCourseForm").css("display", "none");
                                    $("#innerChangeCont").css("display", "block");
                                    showStudents();
                                    showCourses();
                                    totalNumOfStudents();
                                    totalNumOfCourses();

                                } else {
                                    console.log("There was an error adding the course.");
                                }
                            });
                }

                //click to update the info of a course
                $("#editCBtn").click(function () {

                    var Course_Name = $('#courseName').val();
                    var description = $('#courseDescription').val();
                    var Cpicture = document.getElementsByName("CEpicture")[0].files[0];
                    var CCurrentImg = $("#editCourseBtn").data("currentcimg");
                    var course_id = $(this).data("course_id");

                    var myFormData = new FormData();
                    myFormData.append('Cpicture', Cpicture, '.png');
                    myFormData.append('Course_Name', Course_Name);
                    myFormData.append('description', description);
                    myFormData.append('CCurrentImg', CCurrentImg);
                    myFormData.append('course_id', course_id);

                    $.ajax({
                        url: '../controllers/courseUpdate.php',
                        data: myFormData,
                        type: 'POST',
                        success: function (data) {
                            if (data === "success") {
                                $("#EditDeleteCourseForm")[0].reset();
                                $("#CimgToDisplayE").css("display", "none");
                                console.log("Course updated successfully!");

                                $(".coursesList").html("");
                                $(".showOrHideEditDeleteCourseForm").css("display", "none");
                                $("#innerChangeCont").css("display", "block");
                                showStudents();
                                showCourses();
                                totalNumOfStudents();
                                totalNumOfCourses();

                            } else {
                                console.log("There was an error updating the course.");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                });

                //delete a course from the system
                $("#dltCBtn").click(function () {
                    var deleteConfirm = confirm("Are you sure you want to delete permenantly from the system?");

                    if (eachCourseNumS == 0 && deleteConfirm) {
                        $.post("../controllers/courseDelete.php", {course_id: $(this).data("course_id")}, function (data) {

                            if (data === "success") {
                                $("#EditDeleteCourseForm")[0].reset();
                                $("#CimgToDisplay").attr("src", "");
                                $("#CimgToDisplay").css("height", "");
                                $("#CimgToDisplayE").attr("src", "");
                                $("#CimgToDisplayE").css("display", "none");
                                console.log("Course deleted successfully!");

                                $(".coursesList").html("");
                                $(".showOrHideEditDeleteCourseForm").css("display", "none");
                                $("#innerChangeCont").css("display", "block");
                                showStudents();
                                showCourses();
                                totalNumOfStudents();
                                totalNumOfCourses();

                            } else {
                                console.log("There was an error deleting the course.");
                            }
                        });
                    } else {
                        alert("You cannot delete the course while students are registered to it!");
                    }
                });
            }
            );
        </script>
    </head>
    <body onload="showStudents();
            showCourses();
            totalNumOfStudents();
            totalNumOfCourses();">
        <div class="container-fluid">
            <div class="row">

                <!--Students-->

                <!--Left side lists-->
                <div class="col-sm-3 studentsContainer">
                    <h3 id="studentsTitle">Students<span class="glyphicon glyphicon-plus-sign plusGlyph"></span></h3><br/>
                    <div class="studentList">
                    </div>
                </div>
                <div class="col-sm-3 coursesContainer">
                    <h3 id="coursesTitle">Courses<span class="glyphicon glyphicon-plus-sign plusCGlyph"></span></h3><br/>
                    <div class="coursesList">
                    </div>
                </div>
                <div class="col-sm-6 changingContainer">
                    <!--shows total of students and courses-->
                    <div id="innerChangeCont">
                        <div id="innerChangeContA"></div>
                        <div id="innerChangeContB"></div>
                    </div>
                    <!--add a new student-->
                    <div class="showOrHideAddStudentForm">
                        <h4>Add Student</h4>
                        <form id="addStudentForm" method="POST">
                            <input id="saveBtn" type="button" class="btn" name="addStudent" value="Save" />
                            <div id="innerForm">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user-graduate"></i> </span><label>Name: </label>
                                    </div>
                                    <input name="Student_Name" class="form-control" placeholder="Full Name" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span><label>Phone: </label>
                                    </div>
                                    <input name="Phone_Number" class="form-control" placeholder="Phone number" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span><label>Email: </label>
                                    </div>
                                    <input id ="addSEmail" name="Semail" class="form-control" placeholder="Email address" type="email">
                                    <div id="emailError"></div>
                                </div><br/>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-picture-o"></i> </span><label>Image: </label>
                                    </div>
                                    <div>
                                        <input type="file" onchange="readURL2(this);" name="Spicture" accept="image/*"><br/><img id="imgToDisplay"/><br/><br/>
                                    </div>
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-book"></i> </span><label>Courses: </label><br/><br/><ul id="addCoursesToStudent"></ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--edit or delete a student form-->
                    <div class="showOrHideEditDeleteStudentForm">
                        <h4>Edit Student Info / Delete Student</h4>
                        <form id="EditDeleteStudentForm" method="POST">
                            <input id="editStuBtn" type="button" class="btn" name="editStudent" value="Save" />
                            <input id="dltSBtn" class="btn" type="button" name="deleteStudent" value="Delete" /><br/><br/>
                            <div id="innerForm">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user-graduate"></i> </span><label>Name: </label>
                                    </div>
                                    <input name="Student_Name" id="editStuName" class="form-control" placeholder="Full Name" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span><label>Phone: </label>
                                    </div>
                                    <input name="Phone_Number" id="editStuPhone" class="form-control" placeholder="Phone number" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span><label>Email: </label>
                                    </div>
                                    <input name="Semail" id="updateDeleteSEmail" class="form-control" placeholder="Email address" type="email">
                                    <div id="editSemailError"></div>
                                </div><br/>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-picture-o"></i> </span><label>Image: </label>
                                    </div>
                                    <div>
                                        <input type="file" onchange="readURL4(this);" name="SEpicture" accept="image/*"><br/><img id="imgToDisplayE"/><br/><br/>
                                    </div>
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-book"></i> </span><label>Courses: </label><br/><br/><ul id="editCoursesForStudent"></ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--student info view-->
                    <div class="showOrHideStudentInfo">
                        <h4 id="studentInfoTitle">Student</h4>                            
                        <div class="row">
                            <div class="col-sm-6">
                                <img id="imgToDisplay"/>
                            </div>
                            <div class="col-sm-6 studentDetails">
                                <div class="innerStudentInfo">
                                    <!-- student name, phone, email, picture -->
                                </div><br/>
                                <div id="coursesOfStudent">
                                    <h4 id="coursesOfStudentlabel">Courses: </h4><br/>
                                    <ul class='row ScourseList'><!-- Course pic, course description, course name --></ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!--Courses-->

                    <!--add a new course form-->
                    <div class="showOrHideAddCourseForm">
                        <h4>Add Course</h4>
                        <form id="addCourseForm" method="POST">
                            <input id="saveCBtn" type="button" class="btn" name="addCourse" value="Save" />
                            <div id="innerForm">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-book"></i> </span><label>Name: </label>
                                    </div>
                                    <input name="Course_Name" class="form-control" placeholder="Course Name" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-book-open"></i> </span><label>Description: </label>
                                    </div>
                                    <input id="addDescr" name="description" class="form-control" placeholder="Course Description" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-picture-o"></i> </span><label>Image: </label>
                                    </div>
                                    <div>
                                        <input type="file" onchange="readURL(this);" name="Cpicture" accept="image/*"><br/><img id="CimgToDisplay"/><br/><br/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--edit or delete a course form-->
                    <div class="showOrHideEditDeleteCourseForm">
                        <h4>Edit Course Info / Delete Course</h4>
                        <form id="EditDeleteCourseForm" method="POST">
                            <input id="editCBtn" type="button" class="btn" name="editCourse" value="Save" />
                            <input id="dltCBtn" class="btn" type="button" name="deleteCourse" value="Delete" /><br/><br/>
                            <div id="innerForm">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-book"></i> </span><label>Name: </label>
                                    </div>
                                    <input id="courseName" name="Course_Name" class="form-control" placeholder="Course Name" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-book-open"></i> </span><label>Description: </label>
                                    </div>
                                    <input id="courseDescription" name="description" class="form-control" placeholder="Course Description" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-picture-o"></i> </span><label>Image: </label>
                                    </div>
                                    <div>
                                        <input type="file" onchange="readURL1(this);" name="CEpicture" accept="image/*"><br/><img id="CimgToDisplayE"/><br/><br/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--course info view-->
                    <div class="showOrHideCourseInfo">
                        <h4 id="courseInfoTitle">Course</h4>                            
                        <div class="row">
                            <div class="col-sm-6">
                                <img id="imgToDisplay"/>
                            </div>
                            <div class="col-sm-6 courseDetails">
                                <div class="innerCourseInfo">
                                    <!-- course name, number of students in course, description -->
                                </div><br/>
                                <div id="studentsOfCourse">
                                    <h4 id="studentOfCourseslabel">Students Taking This Course: </h4><br/>
                                    <ul class='row CStudentList'><!-- student name and picture --></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>                                


