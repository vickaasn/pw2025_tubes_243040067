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
</head>


<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <section class="home-section">
            <div class="slider">
                <div class="slider__slider slidel">
                    <div class="overlay"></div>
                    <div class="slide-detai1">
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
                        <h1>welcome to my shop</h1>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate iure dicta excepturi molestiae odio quia eius saepe itaque dolore earum.</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide3">
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
                <div class="slider__slider slide4">
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
                <div class="slider__slider slide5">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>welcome to my shop</h1>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate iure dicta excepturi molestiae odio quia eius saepe itaque dolore earum.</p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
            </div>
            <!-- slide end -->
            <div class="left-arrow"><i class="bx bxc-left-arrow"></i></div>
            <div class="right-arrow"><i class="bx bxc-right-arrow"></i></div>
        </section>
    </div>
    <!-- home slide end -->
    <section class="thumb">
        <div class="box-container">
            <div class="box">
                <img src="" alt="">
                <h3>green tea</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sunt, odit.</p>
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="box">
                <img src="" alt="">
                <h3>green tea</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sunt, odit.</p>
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="box">
                <img src="" alt="">
                <h3>green tea</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sunt, odit.</p>
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="box">
                <img src="" alt="">
                <h3>green tea</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sunt, odit.</p>
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
                <span>healty tea</span>
                <h1>save up to 50% off</h1>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facilis voluptas reprehenderit quidem consectetur alias natus in beatae quas ipsum facere?</p>
            </div>
        </div>
    </section>
    <section class="shop">
        <div class="title">
            <img src="" alt="">
            <h1>Trending Products</h1>
        </div>
        <div class="row">
            <img src="" alt="">
            <div class="row-detail">
                <img src="" alt="">
                <div class="top-footer">
                    <h1>a cup of green tea makes you healty</h1>
                </div>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <img src="" alt="">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="" alt="">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="" alt="">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="" alt="">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="" alt="">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="" alt="">
                <a href="view_product.php" class="btn">shop now</a>
            </div>
        </div>
    </section>
    <section class="shop-category">
        <div class="box-container">
            <div class="box">
                <img src="" alt="">
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
                <img src="" alt="">
                <div class="detail">
                    <h3>great savings</h3>
                    <p>save big every order</p>
                </div>
            </div>
            <div class="box">
                <img src="" alt="">
                <div class="detail">
                    <h3>24*7 support</h3>
                    <p>one-on-one support</p>
                </div>
            </div>
            <div class="box">
                <img src="" alt="">
                <div class="detail">
                    <h3>gift voucher</h3>
                    <p>voucher on every festifals</p>
                </div>
            </div>
            <div class="box">
                <img src="" alt="">
                <div class="detail">
                    <h3>worldwide delivery</h3>
                    <p>dropsgip woldwide</p>
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