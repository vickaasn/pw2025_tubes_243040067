<?php
include 'components/connection.php';
session_start();

// Inisialisasi array pesan jika belum ada
if (!isset($warning_msg)) {
    $warning_msg = [];
}
if (!isset($success_msg)) {
    $success_msg = [];
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit(); // Selalu gunakan exit() setelah header redirect
}

// update product in cart
if (isset($_POST['update_cart'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_NUMBER_INT); // Lebih spesifik untuk ID
    $qty = filter_var($_POST['qty'], FILTER_VALIDATE_INT); // Validasi kuantitas sebagai integer

    // Periksa apakah qty valid setelah filter
    if ($qty === false || $qty < 1 || $qty > 99) {
        $warning_msg[] = 'Kuantitas tidak valid! Harus antara 1 dan 99.';
    } else {
        $update_qty = $conn->prepare("UPDATE `cart` SET `qty` = ? WHERE `id` = ?"); // Perbaiki backticks
        $update_qty->execute([$qty, $cart_id]);

        $success_msg[] = 'Kuantitas keranjang berhasil diperbarui!'; // Pesan lebih jelas
    }
}

// delete item from cart (perbaikan: ini seharusnya untuk cart, bukan wishlist)
if (isset($_POST['delete_item'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_NUMBER_INT); // Lebih spesifik untuk ID

    $varify_delete_items = $conn->prepare("SELECT * FROM `cart` WHERE `id` = ?"); // Perbaiki backticks
    $varify_delete_items->execute([$cart_id]); // PERBAIKAN: Gunakan $cart_id, bukan $wishlist_id

    if ($varify_delete_items->rowCount() > 0) {
        $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE `id` = ?"); // Perbaiki backticks, nama variabel lebih jelas
        $delete_cart_item->execute([$cart_id]); // PERBAIKAN: Gunakan $cart_id, bukan $wishlist_id
        $success_msg[] = "Item keranjang berhasil dihapus!";
    } else {
        $warning_msg[] = 'Item keranjang sudah dihapus!'; // Pesan lebih jelas
    }
}

// empty cart
if (isset($_POST['empty_cart'])) {
    $varify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?"); // Perbaiki backticks
    $varify_empty_item->execute([$user_id]);

    if ($varify_empty_item->rowCount() > 0) {
        $delete_all_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?"); // Perbaiki backticks, nama variabel lebih jelas
        $delete_all_cart_items->execute([$user_id]);
        $success_msg[] = "Keranjang berhasil dikosongkan!";
    } else {
        $warning_msg[] = 'Keranjang sudah kosong!'; // Pesan lebih jelas
    }
}

// Inisialisasi variabel untuk sweetalert
// Jika Anda menggunakan komponen alert.php, pastikan variabel ini diinisialisasi
// Jika tidak, Anda bisa menghapusnya atau mengimplementasikan logic sweetalert di sini
// if (!isset($warning_msg)) $warning_msg = [];
// if (!isset($success_msg)) $success_msg = [];

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
    <title>Green Coffe - My Cart</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>my cart</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>cart</span>
        </div>
        <section class="products">
            <h1 class="title">products added in cart</h1>
            <div class="box-container">
                <?php
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?"); // Perbaiki backticks
                $select_cart->execute([$user_id]);
                if ($select_cart->rowCount() > 0) {
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        // PERBAIKI: Query untuk products, gunakan backticks yang benar dan hapus tanda '?' yang salah posisi
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$fetch_cart['product_id']]);
                        if ($select_products->rowCount() > 0) {
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);

                ?>
                            <form method="post" action="" class="box">
                                <input type="hidden" name="cart_id" value="<?= htmlspecialchars($fetch_cart['id']); ?>">
                                <img src="Assets/img/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Gambar <?= htmlspecialchars($fetch_products['name']); ?>" class="product-image">
                                <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                                <div class="flex">
                                    <p class="price">price $<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                                    <input type="number" name="qty" required min="1" value="<?= htmlspecialchars($fetch_cart['qty']); ?>" max="99" maxlength="2" class="qty">
                                    <button type="submit" name="update_cart" class="bx bxs-edit fa-edit"></button>
                                </div>
                                <p class="sub-total">sub total: <span>$<?= $sub_total = ($fetch_cart['qty'] * $fetch_cart['price']) ?></span></p>
                                <button type="submit" name="delete_item" class="btn" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">delete</button>
                            </form>
                <?php
                            $grand_total += $sub_total;
                        } else {
                            echo '<p class="empty">Produk tidak ditemukan!</p>';
                        }
                    }
                } else {
                    echo '<p class="empty">Tidak ada produk di keranjang!</p>';
                }
                ?>
            </div>
            <?php
            if ($grand_total > 0) { // Gunakan '>' bukan '!=' jika 0 adalah nilai awal
            ?>
                <div class="cart-total">
                    <p>total jumlah yang harus dibayar : <span>$ <?= htmlspecialchars($grand_total); ?></span></p>
                    <div class="button">
                        <form method="post">
                            <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang Anda?')">empty cart</button>
                        </form>
                        <form method="post" action="checkout.php">
                            <button type="submit" name="place_order" class="btn">lanjut ke checkout</button>
                        </form>

                    </div>
                </div>
            <?php } ?>

        </section>
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>