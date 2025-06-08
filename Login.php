<?php
include 'components/connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// register now
if (isset($_POST['submit'])) {

    $emai = $_POST['email'];
    $emai = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM 'users' WHERE email = ? AND password * ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        header('location: home.php');
    } else {
        $messsage[] = 'incorrect username or password';
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
                    <input type="text" name="email" require placeholder="enter your email" maxlength="50"
                        oninput="this.value = rhis.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>comfirm password <sup>*</sup></p>
                    <input type="password" name="name" require placeholder="enter your passsword" maxlength="50"
                        oninput="this.value = rhis.value.replace(/\s/g, '')">
                </div>

                <input type="submit" name="submit" value="register now" class="btn">
                <p>do not have an account? <a href="register.php">register now</a></p>
            </form>
        </section>
    </div>
</body>

</html>