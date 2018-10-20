numOfCourses = 0;

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

function totalNumOfCourses() {
    $.getJSON("../controllers/courseController.php", function (courses)
    {
        numOfCourses = courses.length;
        $("#innerChangeContB").html("<h1 class='totals'>And A Total Of " + numOfCourses + " Courses</h1>");
    });
}

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

            var editCourseBtn = `<input data-course_id='${($courseInfo.course_id)}' id='editCourseBtn' type='button' class='btn' name='course' value='Edit' />`;

            var courName = "<div class='courInfo'><h3>" + $courseInfo.Course_Name + "</h3></div>";
            var courDescription = "<div class='courInfo desc'><h5>Description: " + $courseInfo.description + "</h5></div><br/>";
            var courPicture = "<div class='courInfo'><img id='coursePic' src='" + $courseInfo.Cpicture + "'/></div>";
            var courDiv = "<div class='eachCour'>" + editCourseBtn + courName + courDescription + courPicture + "</div>";
            $(".innerCourseInfo").append(courDiv);
            showNumOfStudents($courseInfo.course_id);
        });
    });

    function showNumOfStudents(course_id)
    {
        $.post("../controllers/courseController.php", {state: 2, course_id: course_id}, function (students)
        {
            $(".CStudentListItems").html("");
            $(".CStudentListItems").css("border-bottom", "none");

            var parsedStudents = JSON.parse(students);

            for (let i = 0; i < parsedStudents.length; i++) {
                let student = parsedStudents[i];
                var CStudentName = "<h5 class='SCInfo'>Student Name: </h5>" + student.Student_Name + "<br/><br/>";
                var CStudentPicture = "<img id='courseOfStudentPics' src='" + student.Spicture + "'/>" + "<br/>";
                var CStudentList = "<li class='col-sm-12 CStudentListItems'>" + CStudentName + CStudentPicture + "</li>";
                $("#studentsOfCourse").append(CStudentList);
            }
        });
    }

    $(".innerCourseInfo").on("click", "#editCourseBtn", function () {

        $(".showOrHideAddStudentForm").css("display", "none");
        $(".showOrHideStudentInfo").css("display", "none");
        $(".showOrHideCourseInfo").css("display", "none");
        $(".showOrHideAddCourseForm").css("display", "none");
        $(".showOrHideEditDeleteStudentForm").css("display", "none");
        $("#innerChangeCont").css("display", "none");

        $(".showOrHideEditDeleteCourseForm").css("display", "block");

        $.post('../controllers/courseController.php', {course_id: $(this).data("course_id"), state: 1}, function (data) {

            $courseInfo = JSON.parse(data);

            $('[name="Course_Name"]').val($courseInfo.Course_Name);
            $('[name="description"]').val($courseInfo.description);
            $('#CimgToDisplayE').attr("src", $courseInfo.Cpicture);

            $('#dltCBtn').data("course_id", $courseInfo.course_id);
            $('#editCBtn').data("course_id", $courseInfo.course_id);
        });
    });

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


    $("#editCBtn").click(function () {

        var Course_Name = $('#courseName').val();
        var description = $('#courseDescription').val();
        var Cpicture = document.getElementsByName("CEpicture")[0].files[0];
        var course_id = $(this).data("course_id");

        var myFormData = new FormData();
        myFormData.append('Cpicture', Cpicture, '.png');
        myFormData.append('Course_Name', Course_Name);

        $.ajax({
            url: '../controllers/uploadCoursePicture.php',
            data: myFormData,
            type: 'POST',
            success: function (data) {
                updateCourse(course_id, Course_Name, description, data);
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });

    function updateCourse(course_id, Course_Name, description, Cpicture)
    {

        $.post("../controllers/courseUpdate.php", {course_id: course_id, Course_Name: Course_Name, description: description, Cpicture: Cpicture},
                function (data) {

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
                });
    }

    $("#dltCBtn").click(function () {

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
    });
}
);



