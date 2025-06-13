<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
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
    <title>SNEAKYPAIR - about us page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1></h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>about</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="Assets/img/about1.jpg">
                <div class="detail">
                    <span>SNEAKYPAIR</span>
                    <h1>Dash Linium</h1>
                    <a href="view_prosucts.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="Assets/img/about2.jpg">
                <div class="detail">
                    <span>SNEAKYPAIR</span>
                    <h1>Careera Eveniing</h1>
                    <a href="view_prosucts.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="Assets/img/about3.jpg">
                <div class="detail">
                    <span>SNEAKYPAIR</span>
                    <h1>Dash Saturn</h1>
                    <a href="view_prosucts.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="Assets/img/about4.jpg">
                <div class="detail">
                    <span>SNEAKYPAIR</span>
                    <h1>Falcon Green</h1>
                    <a href="view_prosucts.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <section class="services">
            <div class="title">
                <img src="Assets/img/logobrand.jpg" alt="">
                <h1>why choose us</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis a ullam libero blanditiis corporis at beatae tenetur facilis ea molestiae.</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="Assets/img/box1.jpg" alt="">
                    <div class="detail">
                        <h3>great savings</h3>
                        <p>save big every order</p>
                    </div>
                </div>
                <div class="box">
                    <img src="Assets/img/bo2.jpg">
                    <div class="detail">
                        <h3>24*7 support</h3>
                        <p>one-on-one support</p>
                    </div>
                </div>
                <div class="box">
                    <img src="Assets/img/box3.jpg">
                    <div class="detail">
                        <h3>gift voucher</h3>
                        <p>voucher on every festifals</p>
                    </div>
                </div>
                <div class="box">
                    <img src="Assets/img/box4.jpg">
                    <div class="detail">
                        <h3>worldwide delivery</h3>
                        <p>dropsgip woldwide</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="about">
            <div class="row">
                <div class="img-box">
                    <video autoplay muted loop>
                        <source src="Assets/video/model2.mp4">
                    </video>
                </div>
                <div class="detail">
                    <h1>SNEAKYPAIR NEW PRODUCT</h1>
                    <p>"New shoes are comfortable, stylish, and high-quality. Making every step light and fashionable. Find your dream shoes for every adventure."</p>
                    <a href="view_products.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <div class="testimonial-container">
            <div class="title">
                <img src="Assets/img/=" alt="">
                <h1>what people say about us</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam delectus illo numquam quia corrupti, aperiam dolores doloremque eveniet architecto, doloribus eaque laudantium iure adipisci quaerat? Quae necessitatibus sequi minus nemo.</p>
            </div>
            <div class="container">
                <div class="testimonial-item active">
                    <img src="Assets/img/testimoni.jpg" alt="">
                    <h1>sara samith</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi quisquam maiores, exercitationem, possimus est dolores molestias quam a veritatis, asperiores labore iste corporis excepturi eos quod doloribus. Dolor, magni consequatur!</p>
                </div>


                <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
            </div>
        </div>
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.mon.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>