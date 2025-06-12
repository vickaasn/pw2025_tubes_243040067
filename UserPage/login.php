<?php

$error = false;
if (isset($_POST["login"])) {
    if ($_POST["username"] == "areva" && $_POST["password"] == "areva22") {
        header("Location: jual.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CarHub Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #024 0%, #0a3d62 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(2, 36, 36, 0.12);
            padding: 36px 28px;
        }

        .login-card img.logo {
            display: block;
            margin: 0 auto 28px;
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 18px rgba(2, 36, 36, 0.18), 0 1.5px 4px rgba(2, 36, 36, 0.10);
            border: 3px solid #024;
            background: #f7faff;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .login-card img.logo:hover {
            transform: scale(1.07) rotate(-3deg);
            box-shadow: 0 8px 32px rgba(2, 36, 36, 0.22), 0 3px 8px rgba(2, 36, 36, 0.13);
        }

        .login-form .form-group label {
            color: #024;
            font-weight: 500;
        }

        .login-form .form-control {
            border-radius: 8px;
            border: 1px solid #b2bec3;
            background: #f7faff;
        }

        .login-form .form-control:focus {
            border-color: #024;
            box-shadow: 0 0 0 2px rgba(2, 36, 36, 0.08);
        }

        .btn-primary {
            background-color: #024;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background-color: #036;
        }

        .alert-danger {
            border-radius: 8px;
        }

        .login-footer {
            text-align: center;
            margin-top: 18px;
            color: #555;
        }

        .register-link {
            color: #024;
            font-weight: 500;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
            color: #036;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" data-aos="fade-down">
        <div class="container">
            <a class="navbar-brand fw-bolder logo" href="#">CarHub</a>
        </div>
        <div></div>
    </nav>
    <!-- card login -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container" data-aos="zoom-in" data-aos-duration="900">
            <div class="login-card">
                <img src="../public/img/logo.jpg" class="logo" data-aos="flip-left" data-aos-duration="1200" alt="CarHub Logo">
                <?php if ($error): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        Username atau password salah!
                    </div>
                <?php endif; ?>
                <form action="" method="POST" class="login-form" data-aos="fade-up" data-aos-delay="200">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required autofocus>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="login-footer mt-3" data-aos="fade-up" data-aos-delay="400">
                    Don't have an account? <a href="register.php" class="register-link">Sign up here</a>
                </p>
            </div>
        </div>
    </div>
    <!-- akhir card login -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>

</html>