
<html>
    <head>
        <title>Administration</title>
        <!--There is a JS folder with separated JS files. 
            JS is also here for the required validations in PHP -->
        <script>

            //admin JS

            numOfUsers = 0;

            //creates the admin divs on the left side list
            function showAdminUsers()
            {
                $.getJSON("../controllers/adminController.php", function (users)
                {
                    $(".userList").html("");


                    for (let i = 0; i < users.length; i++) {
                        let user = users[i];
                        if (user.role != "Owner" || '<?php echo currentRole ?>' == 'Owner') {
                            var userName = "<div class='userInfo'><h3>" + user.User_Name + "</h3></div>";
                            var userEmail = "<div class='userInfo'><h5>" + user.email + "</h5></div>";
                            var userPhone = "<div class='userInfo'><h5>" + user.Phone_Number + "</h5></div>";
                            var userRole = "<div class='userInfo'><h5>" + user.role + "</h5></div>";
                            var userPicture = "<div class='userInfo'><img id='adminpic' src='" + user.picture + "'/></div>";
                            var userDiv = `<div class='eachUser' data-admin_id='${user.admin_id}'>` + userName + userEmail + userPhone + userRole + userPicture + "</div>";
                            $(".userList").append(userDiv);
                        }
                    }
                });
            }

            //shows total number of admins in the "changing container"
            function totalNumOfUsers() {
                $.getJSON("../controllers/adminController.php", function (users)
                {
                    numOfUsers = users.length;
                    $("#innerChangeContC").html("<h1 class='totals'>There Are A Total Of " + numOfUsers + " Users</h1>");
                });
            }

            //shows preview of picture on the "add admin" form
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

            //shows preview of picture on the "edit or delete admin" form
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

                //to reach the add new admin form
                $(".plusGlyph").click(function () {
                    $('[name="User_Name"]').val("");
                    $('[name="password"]').val("");
                    $('#addEmail').val("");
                    $('#addEmail').blur(function () {
                        emailExist3($('#addEmail').val());
                    });
                    $('[name="Phone_Number"]').val("");
                    $("#AimgToDisplayE").attr("src", "");
                    $("#AimgToDisplayE").css("height", "");
                    $(".showOrHideEditDeleteForm").css("display", "none");
                    $("#innerChangeCont").css("display", "none");
                    $(".showOrHideAddForm").css("display", "block");
                });

                //show admin info in the edit or delete form
                $(".userList").on("click", ".eachUser", function () {

                    $(".showOrHideAddForm").css("display", "none");
                    $("#innerChangeCont").css("display", "none");
                    $(".showOrHideEditDeleteForm").css("display", "block");

                    $.post('../controllers/adminController.php', {admin_id: $(this).data("admin_id"), state: 1}, function (data) {

                        $userInfo = JSON.parse(data);

                        $('[name="User_Name"]').val($userInfo.User_Name);
                        $('[name="password"]').val($userInfo.password);
                        $('#editAdminEmail').val($userInfo.email);
                        $('#editAdminEmail').blur(function () {
                            emailExist4($('#editAdminEmail').val());
                        });
                        $('[name="Phone_Number"]').val($userInfo.Phone_Number);
                        $('[name="role"]').val($userInfo.role);
                        $('#AimgToDisplayE').attr("src", $userInfo.picture);

                        $('#dltBtn').data("admin_id", $userInfo.admin_id);
                        $('#editBtn').data("admin_id", $userInfo.admin_id);
                        $('#editBtn').data("currentaimg", $userInfo.picture);


                        if ("<?php echo currentRole ?>" == "Manager" && $userInfo.role == "Manager") {
                            $('#dltBtn').hide();
                        } else {
                            $('#dltBtn').show();
                        }

                        if ('<?php echo currentEmail ?>' == $userInfo.email || $userInfo.role == "Sales") {
                            $('#editBtn').show();
                        } else {
                            $('#editBtn').hide();

                        }

                        if ("<?php echo currentRole ?>" == "Manager" && $userInfo.role == "Manager") {
                            $('#editAdminRole').attr("disabled", true);
                        } else {
                            $('#editAdminRole').attr("disabled", false);
                        }


                        if ("<?php echo currentRole ?>" == "Owner") {
                            $('#dltBtn').show();
                            $('#editBtn').show();
                        }
                    });
                });

                //check if email exists when adding a new admin
                function emailExist3(email) {

                    $.post("../controllers/adminController.php", {email: email, state: 3}
                    ,
                            function (data) {

                                if (data) {
                                    $("#addAEmailErr").show();
                                    $("#addAEmailErr").html("<h6>'Email already exists in the system'</h6>")
                                } else if (!data) {
                                    $("#addAEmailErr").hide();
                                }
                            });
                }

                //check if email exists when editing a admin
                function emailExist4(email) {

                    $.post("../controllers/adminController.php", {email: email, state: 3}
                    ,
                            function (data) {

                                if (data) {
                                    $("#editAEmailErr").show();
                                    $("#editAEmailErr").html("<h6>'Email already exists in the system'</h6>")
                                } else if (!data) {
                                    $("#editAEmailErr").hide();
                                }
                            });
                }

                //clicking "save" after adding a new admin to the system
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

                //(continuation) saving a new admin to the system 
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

                //clicking "save" after editing an admin
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
                    var currentaimg = $("#editBtn").data("currentaimg");
                    var admin_id = $(this).data("admin_id");

                    var myFormData = new FormData();
                    myFormData.append('picture', picture, '.png');
                    myFormData.append('User_Name', User_Name);
                    myFormData.append('password', password);
                    myFormData.append('email', email);
                    myFormData.append('Phone_Number', Phone_Number);
                    myFormData.append('role', role);
                    myFormData.append('currentaimg', currentaimg);
                    myFormData.append('admin_id', admin_id);

                    $.ajax({
                        url: '../controllers/adminUpdate.php',
                        data: myFormData,
                        type: 'POST',
                        success: function (data) {
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
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                });

                //deleting an admin from the system
                $("#dltBtn").click(function () {

                    var deleteConfirm = confirm("Are you sure you want to delete permenantly from the system?");

                    if (deleteConfirm) {
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
                    }
                });

            });
        </script>
    </head>
    <body onload="showAdminUsers();
            totalNumOfUsers();">
        <div class="container-fluid">
            <div class="row">

                <!--Left side list-->
                <div class="col-sm-3 adminContainer">
                    <h3 id="adminTitle">Administrators<span class="glyphicon glyphicon-plus-sign plusGlyph"></span></h3><br/>
                    <div class="userList">
                    </div>
                </div>
                <div class="col-sm-9 changingContainer">

                    <!--shows total of administrators-->
                    <div id="innerChangeCont">
                        <div id="innerChangeContC"></div>
                    </div>

                    <!--add a new admin-->
                    <div class="showOrHideAddForm">
                        <h4>Add Administrator</h4>
                        <form id="addAdminForm" method="POST">
                            <input id="saveBtn" type="button" class="btn" name="addUser" value="Save" />
                            <div id="innerForm">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span><label>Name: </label>
                                    </div>
                                    <input name="User_Name" class="form-control" placeholder="Full Name" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-key"></i> </span><label>Password: </label>
                                    </div>
                                    <input name="password" class="form-control" placeholder="Password" type="password">
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
                                    <input id="addEmail" name="email" class="form-control" placeholder="Email address" type="email">
                                    <div id="addAEmailErr"></div>
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-th-large"></i> </span><label>Role: </label>
                                    </div>
                                    <select name="role" class="form-control">
                                        <option selected=""> Select Role </option>
                                        <option selected="Manager">Manager</option>
                                        <option selected="Sales">Sales</option>
                                    </select>
                                </div><br/>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-picture-o"></i> </span><label>Image: </label>
                                    </div><br/>
                                    <div>
                                        <input type="file" onchange="readURL3(this);" name="picture" accept="image/*"><br/><img id="AimgToDisplay"/><br/><br/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--edit or delete an admin-->
                    <div class="showOrHideEditDeleteForm">
                        <h4>Edit Administrator Info / Delete Administrator</h4>
                        <form id="EditDeleteAdminForm" method="POST">
                            <input id="editBtn" type="button" class="btn" name="editUser" value="Save" />
                            <input id="dltBtn" class="btn" type="button" name="deleteUser" value="Delete" /><br/><br/>
                            <div id="innerForm">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span><label>Name: </label>
                                    </div>
                                    <input name="User_Name" class="form-control" placeholder="Full Name" type="text">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-key"></i> </span><label>Password: </label>
                                    </div>
                                    <input name="password" class="form-control" placeholder="Password" type="password">
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
                                    <input id="editAdminEmail" name="email" class="form-control" placeholder="Email address" type="email">
                                    <div id="editAEmailErr"></div>
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-th-large"></i> </span><label>Role: </label>
                                    </div>
                                    <select id="editAdminRole" name="role" class="form-control">
                                        <option selected=""> Select Role </option>
                                        <option selected="Manager">Manager</option>
                                        <option selected="Sales">Sales</option>
                                    </select>
                                </div><br/>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-picture-o"></i> </span><label>Image: </label>
                                    </div><br/>
                                    <div>
                                        <input type="file" onchange="readURL5(this);" name="Epicture" accept="image/*"><br/><img id="AimgToDisplayE"/><br/><br/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

