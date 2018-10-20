
<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-5 col-md-3">
                    <div method ='post' action='' class="form-login">
                        <h1>Welcome To Our School's DataBase!</h1><br/>
                        <h4>Please Log In Below: </h4><br/>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="Your School Email Address">     
                        </div>
                        <div>
                            <span id="userErr"></span>
                        </div>
                        </br>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div>
                            <span id="pswrdErr"></span>
                        </div>
                        </br>
                        <div class="wrapper">
                            <span class="group-btn">     
                                <button <span id="loginbtn" class="btn btn-primary btn-md">Login <i class="fa fa-sign-in-alt"></i></span></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
