<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../db.php');

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, email, name, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            session_regenerate_id(); // Regenerate session ID for security
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_email"] = $row["email"];
            header("Location: index.php");
            exit();
        } else {
            $login_error = "Incorrect email or password.";
        }
    } else {
        $login_error = "Incorrect email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .login-logo {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="login-container">
                    <div class="login-logo">
                        <img src="../assets/img/main-logo.png" alt="Logo" width="150">
                    </div>
                    <form method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" required name="email">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" placeholder="Password" required name="password">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="show-hide-password">
                                        <i class="fa fa-eye-slash" aria-hidden="true" id="password-icon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script>
        // Toggle password visibility
        $('#show-hide-password').click(function(){
            var passwordInput = $('#password');
            var passwordIcon = $('#password-icon');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordInput.attr('type', 'password');
                passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    </script>
</body>
</html>
