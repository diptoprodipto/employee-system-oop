<?php
// include "session.php";

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_POST['remember-me'])) {
        setcookie("user", $email, time() + 86400);
    } else if (!isset($_POST['remember-me']) && $_COOKIE['user']) {
        $cookied_user = $_COOKIE['user'];
        setcookie("user", $cookied_user, time()-1);
    }

    $exist = $db->conn->query("SELECT * FROM `employees` WHERE `email`='$email';");

    if ($exist->num_rows == 1) {
        $_SESSION['user'] = $email;
        header("location: index.php");
    } else {
        echo "
        <script>
            alert('login failed!!!')
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
</head>
<body>
    <div id="login" style="background-color: #17a2b8">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12 bg-dark">
                        <form id="login-form" class="form" action="" method="POST">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <br/>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>        
                                <br/>
                                <input type="submit" name="login" class="btn btn-info btn-md" value="Login">
                                <br/><br/>
                                <!-- <a href="register.php" class="text-info">Register here</a> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>

    body {
        margin: 0;
        padding: 0;
        background-color: #17a2b8;
        height: 100vh;
    }
    #login .container #login-row #login-column #login-box {
        margin-top: 120px;
        max-width: 600px;
        height: 320px;
        border: 1px solid #9C9C9C;
        background-color: #EAEAEA;
    }
    #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
    }
    #login .container #login-row #login-column #login-box #login-form #register-link {
        margin-top: -85px;
    }
</style>
    
</body>
</html>