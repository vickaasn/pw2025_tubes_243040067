<?php
include 'components/connection.php';
session_start();

if (!isset($message)) {
    $message = [];
}

if (!function_exists('unique_id')) {
    function unique_id()
    {
        return uniqid('', true);
    }
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit-btn'])) {

    // $id = unique_id(); hapus

    $name = $_POST['name'] ?? '';
    $name = trim($name);
    if (empty($name)) {
        $message[] = 'Nama tidak boleh kosong!';
    } elseif (strlen($name) < 2) {
        $message[] = 'Nama terlalu pendek!';
    }

    $email = $_POST['email'] ?? '';
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
        $message[] = 'Email tidak boleh kosong!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Format email tidak valid!';
    }

    $pass = $_POST['pass'] ?? '';
    $cpass = $_POST['cpass'] ?? '';

    if (empty($pass)) {
        $message[] = 'Password tidak boleh kosong!';
    } elseif (strlen($pass) < 6) {
        $message[] = 'Password minimal 6 karakter!';
    } elseif ($pass !== $cpass) {
        $message[] = 'Konfirmasi password tidak cocok!';
    } else {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    }

    if (empty($message)) {
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);

        if ($select_user->rowCount() > 0) {
            $message[] = 'Email sudah terdaftar!';
        } else {
            $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (?, ?, ?, 'user')");
            $insert_user->execute([$name, $email, $hashed_password]);

            // Ambil ID yang baru dibuat oleh database untuk dimasukkan ke session
            $new_user_id = $conn->lastInsertId();

            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            $message[] = 'Registrasi berhasil! Anda akan diarahkan...';
            header('location: home.php');
            exit();
        }
    }
}
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Yeseva+One&display=swap" rel="stylesheet">
    <title>SneakPair - register now</title>
</head>

<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="Assets/img" alt="">
                <h1>register now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, quidem. Numquam minus quo asperiores facere molestias labore, quisquam voluptas dolorem repudiandae eum temporibus, officiis suscipit, unde fuga corporis. Ducimus, hic.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>your name <sup>*</sup></p>
                    <input type="text" name="name" required placeholder="enter your name" maxlength="50">
                </div>
                <div class="input-field">
                    <p>your email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="enter your email" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>your password <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="enter your password" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>confirm password <sup>*</sup></p>
                    <input type="password" name="cpass" required placeholder="confirm your password" maxlength="50"
                        oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <input type="submit" name="submit-btn" value="register now" class="btn">

                <p>alredy have an account? <a href="login.php">login now</a></p>
            </form>
        </section>
    </div>
</body>

</html>