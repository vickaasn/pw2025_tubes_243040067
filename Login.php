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
    header('location: home.php');
    exit();
} else {
    $user_id = '';
}

if (isset($_POST['submit-btn'])) {

    $email = $_POST['email'] ?? '';
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
        $message[] = 'Email tidak boleh kosong!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Format email tidak valid!';
    }

    $pass = $_POST['pass'] ?? '';
    if (empty($pass)) {
        $message[] = 'Password tidak boleh kosong!';
    }

    if (empty($message)) {
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);

        if ($select_user->rowCount() > 0) {
            $row = $select_user->fetch(PDO::FETCH_ASSOC);

            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];

                $message[] = 'Login berhasil! Anda akan diarahkan...';
                header('location: home.php');
                exit();
            } else {
                $message[] = 'Email atau password salah!';
            }
        } else {
            $message[] = 'Email atau password salah!';
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
    <title>SneakPair - logiin now</title>
</head>

<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="" alt="">
                <h1>login now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, quidem. Numquam minus quo asperiores facere molestias labore, quisquam voluptas dolorem repudiandae eum temporibus, officiis suscipit, unde fuga corporis. Ducimus, hic.</p>
            </div>
            <form action="" method="post">
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

                <input type="submit" name="submit-btn" value="login now" class="btn">
                <p>do not have an account? <a href="register.php">register now</a></p>
            </form>

        </section>
    </div>
</body>

</html>