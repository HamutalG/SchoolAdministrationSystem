
$(function () {
    $("#loginbtn").click(function () {

        var nameInput = $("#login-username").val();
        var passInput = $("#login-password").val();
        $.post("../controllers/loginController.php", {name: nameInput, password: passInput}, function (data) {
            if (data == "Incorrect Username!") {
                $("#userErr").html("");
                $("#userErr").html(data);
            } else if (data == "Incorrect Password!") {
                $("#userErr").html("");
                $("#pswrdErr").html(data);
            } else {
                window.location.href = "/school";
            }
        });
    });

    // hamburger menu

    $(".menu").click(function () {
        $(".navbarLinks").toggleClass("active");
    });
});


