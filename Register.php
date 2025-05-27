<?php
if (isset($_POST["submit"])) {
    if ($_POST["fullname"] == "Vicka Aulia Shafira Nurwina" && $_POST["username"] == "admin" && $_POST["password"] == "admin") {
        header("Location: Login.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, rgb(241, 188, 206), rgb(216, 140, 165));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .videobg video {
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            position: fixed;
            overflow: hidden;
            z-index: -1;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgb(255, 255, 255);
            width: 350px;
            text-align: center;
            position: absolute;
            color: white;
            z-index: 1;
        }


        h1 {
            margin-bottom: 20px;
            color: rgb(255, 255, 255);
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: rgb(255, 255, 255);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: rgb(0, 0, 0);
            color: white;
            border: none;
            border-radius: 8px;
            margin-top: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(182, 169, 173);
        }

        .error {
            color: red;
            font-style: italic;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="videobg">
        <video autoplay muted loop>
            <source src="Assets/video/bg.mp4">
        </video>
    </div>
    <div class="login-container">
        <h1>Register</h1>
        <img src="" alt="">

        <?php if (isset($error)) : ?>
            <p class="error">username / password salah!</p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="fullname">Full Name :</label>
            <input type="text" name="fullname" id="fullname">

            <label for="username">Username :</label>
            <input type="text" name="username" id="username">

            <label for="password">Password :</label>
            <input type="password" name="password" id="password">

            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>

</html>