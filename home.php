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
    <title>Green Coffe - home page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Yeseva+One&display=swap" rel="stylesheet">
</head>


<body>
    <?php include 'components/header.php'; ?>
    <div class="main">

        <section class="home-section">
            <div class="slider">
                <div class="slider__slider slidel">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>welcome to my shop</h1>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate iure dicta excepturi molestiae odio quia eius saepe itaque dolore earum.</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide2">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide3">
                    <div class="overlay"></div>
                    <div class="slide-detail">

                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
            </div>
            <!-- slide end -->

        </section>
    </div>
    <!-- home slide end -->
    <section class="thumb">
        <div class="box-container">
            <div class="box">
                <img src="Assets/img/thumb1.jpg">
                <h3>Shop Now</h3>
                <p>Discover the latest sneaker collection with maximum style and comfort. Ready to check out!</p>
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="box">
                <img src="Assets/img/thumb2.jpg">
                <h3>Store Location</h3>
                <p>Visit our physical store and explore a wide range of trendy sneakers in person.</p>
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="box">
                <img src="Assets/img/thumb3.jpg">
                <h3>New Arrivals</h3>
                <p>Check out our latest releases with exclusive designs only at SNEAKYPAIR.</p>
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="box">
                <img src="Assets/img/thumb4.jpg">
                <h3>Featured Sneaker</h3>
                <p>Top pick sneakers for everyday style and active life. Comfortable and fashionable!</p>
                <i class="bx bx-chevron-right"></i>
            </div>
        </div>
    </section>
    <section class="container">
        <div class="box-container">
            <div class="box">
                <img src="Assets/img/bg2-removebg-preview.png">
            </div>
            <div class="box">
                <img src="" alt="">
                <span>Mid-Year Sale</span>
                <h1>save up to 50% off</h1>
                <p>Don’t miss the trend! Get exclusive discounts on our most popular sneaker collections.</p>
            </div>
        </div>
    </section>
    <section class="shop">
        <div class="title">
            <img src="">
            <h1>Trending Products</h1>
        </div>

        <div class="row">
            <video autoplay muted loop>
                <source src="Assets/video/model1.mp4">
            </video>
            <div class="row-detail">
                <img src="Assets/img/model2.png" alt="">
                <div class="top-footer">
                    <h1>A pair of good sneakers keeps you moving</h1>
                </div>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <img src="Assets/img/shop1.jpeg">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="Assets/img/shop3.jpg">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="Assets/img/shop6.jpg">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="Assets/img/shop4.jpg">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="Assets/img/shop5.jpg">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
        </div>
    </section>
    <section class="shop-category">
        <div class="box-container">
            <div class="box">
                <video autoplay muted loop>
                    <source src="Assets/video/">
                </video>

                <div class="detail">
                    <span>BIG OFFERS</span>
                    <h1>Extra 15% off</h1>
                    <a href="view_product.php" class="btn">shop now</a>
                </div>
            </div>
            <div class="box">
                <img src="" alt="">
                <div class="detail">
                    <span>now in taster</span>
                    <h1>coffe house</h1>
                    <a href="view_product.php" class="btn">shop now</a>
                </div>
            </div>
        </div>
    </section>
    <section class="services">
        <div class="box-container">
            <div class="box">
                <img src="Assets/img/box1.jpg">
                <div class="detail">
                    <h3>great savings</h3>
                    <p>Enjoy exclusive deals and discounts on every sneaker purchase.</p>
                </div>
            </div>
            <div class="box">
                <img src="Assets/img/bo2.jpg">
                <div class="detail">
                    <h3>24*7 support</h3>
                    <p>We're here for you anytime — 24/7 customer support.</p>
                </div>
            </div>
            <div class="box">
                <img src="Assets/img/box3.jpg">
                <div class="detail">
                    <h3>gift voucher</h3>
                    <p>Gift cards and vouchers available for all special occasions.</p>
                </div>
            </div>
            <div class="box">
                <img src="Assets/img/box4.jpg">
                <div class="detail">
                    <h3>worldwide delivery</h3>
                    <p>Fast and secure shipping to customers around the world.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="brand">
        <div class="box-container">
            <div class="box">
                <img src="" alt="">
            </div>
            <div class="box">
                <img src="" alt="">
            </div>
            <div class="box">
                <img src="" alt="">
            </div>
            <div class="box">
                <img src="" alt="">
            </div>
            <div class="box">
                <img src="" alt="">
            </div>
        </div>
    </section>
    <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.mon.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>