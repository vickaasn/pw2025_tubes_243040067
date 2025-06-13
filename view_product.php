<?php
include 'components/connection.php';
session_start();

$warning_msg = [];
$success_msg = [];
$message = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}

// adding products in wishlist
if (isset($_POST['add_to_wishlist'])) {
    if ($user_id == '') {
        $warning_msg[] = 'Silakan login terlebih dahulu untuk menambahkan ke wishlist!';
    } else {

        $product_id = htmlspecialchars(trim($_POST['product_id'] ?? ''), ENT_QUOTES, 'UTF-8');

        $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->execute([$user_id, $product_id]);

        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $cart_num->execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'Produk sudah ada di wishlist Anda!';
        } else if ($cart_num->rowCount() > 0) {
            $warning_msg[] = 'Produk sudah ada di keranjang Anda!';
        } else {
            $select_price = $conn->prepare("SELECT `price` FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            if ($fetch_price) {

                $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (`user_id`, `product_id`, `price`) VALUES(?,?,?)");
                $insert_wishlist->execute([$user_id, $product_id, $fetch_price['price']]);
                $success_msg[] = 'Produk berhasil ditambahkan ke wishlist!';
            } else {
                $warning_msg[] = 'Produk tidak ditemukan!';
            }
        }
    }
}

// adding products in cart
if (isset($_POST['add_to_cart'])) {
    if ($user_id == '') {
        $warning_msg[] = 'Silakan login terlebih dahulu untuk menambahkan ke keranjang!';
    } else {
        $product_id = htmlspecialchars(trim($_POST['product_id'] ?? ''), ENT_QUOTES, 'UTF-8');

        $qty = filter_var($_POST['qty'] ?? 1, FILTER_VALIDATE_INT);

        if ($qty === false || $qty < 1 || $qty > 99) {
            $warning_msg[] = 'Kuantitas tidak valid! Harus antara 1 dan 99.';
            $qty = 1;
        } else {
            $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
            $verify_cart->execute([$user_id, $product_id]);

            $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $max_cart_items->execute([$user_id]);

            if ($verify_cart->rowCount() > 0) {
                $warning_msg[] = 'Produk sudah ada di keranjang!';
            } else if ($max_cart_items->rowCount() >= 20) {
                $warning_msg[] = 'Keranjang sudah penuh! Hapus beberapa item atau check out.';
            } else {
                $select_price = $conn->prepare("SELECT `price` FROM `products` WHERE id = ? LIMIT 1");
                $select_price->execute([$product_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                if ($fetch_price) {
                    // ✅ ID tidak dimasukkan
                    $insert_cart = $conn->prepare("INSERT INTO `cart` (`user_id`, `product_id`, `price`, `qty`) VALUES(?,?,?,?)");
                    $insert_cart->execute([$user_id, $product_id, $fetch_price['price'], $qty]);
                    $success_msg[] = 'Produk berhasil ditambahkan ke keranjang!';
                } else {
                    $warning_msg[] = 'Produk tidak ditemukan!';
                }
            }
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
    <title>SNEAKYPAIR - shop page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">

        </div>
        <div class="title2">
            <a href="home.php">home </a><span>our shop</span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <form action="" method="post" class="box">
                            <img src="Assets/img/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Gambar <?= htmlspecialchars($fetch_products['name']); ?>" class="product-image">
                            <div class="button">
                                <button type="submit" name="add_to_cart" value="add_to_cart" title="Add to Cart"><i class="bx bx-cart"></i></button>
                                <button type="submit" name="add_to_wishlist" value="add_to_wishlist" title="Add to Wishlist"><i class="bx bx-heart"></i></button>
                                <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>" class="bx bxs-show" title="View Product"></a>
                            </div>
                            <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">

                            <div class="flex">
                                <p class="price">price $<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                                <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">

                            </div>
                            <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">buy now</a>
                        </form>
                <?php
                    }
                } else {
                    echo '<p class="empty">no products added yet!</p>';
                }
                ?>
            </div>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>

</body>

</html>