numOfUsers = 0;

function showAdminUsers()
{
    $.getJSON("../controllers/adminController.php", function (users)
    {
        $(".userList").html("");

        for (let i = 0; i < users.length; i++) {
            let user = users[i];
            var userName = "<div class='userInfo'><h3>" + user.User_Name + "</h3></div>";
            var userEmail = "<div class='userInfo'><h5>" + user.email + "</h5></div>";
            var userPhone = "<div class='userInfo'><h5>" + user.Phone_Number + "</h5></div>";
            var userRole = "<div class='userInfo'><h5>" + user.role + "</h5></div>";
            var userPicture = "<div class='userInfo'><img id='adminpic' src='" + user.picture + "'/></div>";
            var userDiv = `<div class='eachUser' data-admin_id='${user.admin_id}'>` + userName + userEmail + userPhone + userRole + userPicture + "</div>";
            $(".userList").append(userDiv);
        }
    });
}

function totalNumOfUsers() {
    $.getJSON("../controllers/adminController.php", function (users)
    {
        numOfUsers = users.length;
        $("#innerChangeContC").html("<h1 class='totals'>There Are A Total Of " + numOfUsers + " Users</h1>");
    });
}

function readURL3(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#AimgToDisplay')
                    .attr('src', e.target.result)
                    .height(100);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL5(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#AimgToDisplayE')
                    .attr('src', e.target.result)
                    .height(100);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function () {

    $(".plusGlyph").click(function () {
        $('[name="User_Name"]').val("");
        $('[name="password"]').val("");
        $('[name="email"]').val("");
        $('[name="Phone_Number"]').val("");
        $("#AimgToDisplayE").attr("src", "");
        $("#AimgToDisplayE").css("height", "");
        $(".showOrHideEditDeleteForm").css("display", "none");
        $("#innerChangeCont").css("display", "none");
        $(".showOrHideAddForm").css("display", "block");
    });

    $(".userList").on("click", ".eachUser", function () {

        $(".showOrHideAddForm").css("display", "none");
        $("#innerChangeCont").css("display", "none");
        $(".showOrHideEditDeleteForm").css("display", "block");

        $.post('../controllers/adminController.php', {admin_id: $(this).data("admin_id"), state: 1}, function (data) {

            $userInfo = JSON.parse(data);

            $('[name="User_Name"]').val($userInfo.User_Name);
            $('[name="password"]').val($userInfo.password);
            $('[name="email"]').val($userInfo.email);
            $('[name="Phone_Number"]').val($userInfo.Phone_Number);
            $('[name="role"]').val($userInfo.role);
            $('#AimgToDisplayE').attr("src", $userInfo.picture);

            $('#dltBtn').data("admin_id", $userInfo.admin_id);
            $('#editBtn').data("admin_id", $userInfo.admin_id);

        });
    });

    $("#saveBtn").click(function () {

        var User_Name = $('[name="User_Name"]').val();
        var password = $('[name="password"]').val();
        var email = $('[name="email"]').val();
        var Phone_Number = $('[name="Phone_Number"]').val();
        var role = $('[name="role"]').val();
        var picture = document.getElementsByName("picture")[0].files[0];
        var admin_id = $(this).data("admin_id");

        var myFormData = new FormData();
        myFormData.append('picture', picture, '.png');
        myFormData.append('User_Name', User_Name);

        $.ajax({
            url: '../controllers/uploadUserPicture.php',
            data: myFormData,
            type: 'POST',
            success: function (data) {
                saveAdmin(admin_id, User_Name, password, email, Phone_Number, role, data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    function saveAdmin(admin_id, User_Name, password, email, Phone_Number, role, picture)
    {

        $.post("../controllers/adminAdd.php", {admin_id: admin_id, User_Name: User_Name, password: password, email: email, Phone_Number: Phone_Number, role: role, picture: picture},
                function (data) {

                    if (data === "success") {
                        $("#addAdminForm")[0].reset();
                        $("#AimgToDisplay").attr("src", "");
                        $("#AimgToDisplay").css("height", "");
                        console.log("User added successfully!");

                        $(".userList").html("");
                        $(".showOrHideAddForm").css("display", "none");
                        $("#innerChangeCont").css("display", "block");
                        showAdminUsers();
                        totalNumOfUsers();
                    } else {
                        console.log("There was an error adding the user.");
                    }
                });
    }


    $("#editBtn").click(function () {

        var uName = $('[name="User_Name"]')[1];
        var User_Name = $(uName).val();
        var psw = $('[name="password"]')[1];
        var password = $(psw).val();
        var uEmail = $('[name="email"]')[1];
        var email = $(uEmail).val();
        var uPhone = $('[name="Phone_Number"]')[1];
        var Phone_Number = $(uPhone).val();
        var uRole = $('[name="role"]')[1];
        var role = $(uRole).val();
        var picture = document.getElementsByName("Epicture")[0].files[0];
        var admin_id = $(this).data("admin_id");

        var myFormData = new FormData();
        myFormData.append('picture', picture, '.png');
        myFormData.append('User_Name', User_Name);

        $.ajax({
            url: '../controllers/uploadUserPicture.php',
            data: myFormData,
            type: 'POST',
            success: function (data) {
                updateAdmin(admin_id, User_Name, password, email, Phone_Number, role, data);
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });

    function updateAdmin(admin_id, User_Name, password, email, Phone_Number, role, picture)
    {

        $.post("../controllers/adminUpdate.php", {admin_id: admin_id, User_Name: User_Name, password: password, email: email, Phone_Number: Phone_Number, role: role, picture: picture},
                function (data) {

                    if (data === "success") {
                        $("#EditDeleteAdminForm")[0].reset();
                        $("#AimgToDisplayE").css("display", "none");
                        console.log("User updated successfully!");

                        $(".userList").html("");
                        $(".showOrHideEditDeleteForm").css("display", "none");
                        $("#innerChangeCont").css("display", "block");
                        showAdminUsers();
                        totalNumOfUsers();

                    } else {
                        console.log("There was an error updating the user.");
                    }
                });
    }

    $("#dltBtn").click(function () {

        $.post("../controllers/adminDelete.php", {admin_id: $(this).data("admin_id")}, function (data) {

            if (data === "success") {
                $("#EditDeleteAdminForm")[0].reset();
                $("#AimgToDisplay").attr("src", "");
                $("#AimgToDisplay").css("height", "");
                console.log("User deleted successfully!");

                $(".userList").html("");
                $(".showOrHideEditDeleteForm").css("display", "none");
                $("#innerChangeCont").css("display", "block");
                showAdminUsers();
                totalNumOfUsers();

            } else {
                console.log("There was an error deleting the user.");
            }
        });

    });

});
