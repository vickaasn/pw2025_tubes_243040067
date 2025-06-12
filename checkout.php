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

// Fungsi unique_id() ini TIDAK LAGI DIPERLUKAN karena ID menggunakan AUTO_INCREMENT.
// Baris ini bisa dihapus sepenuhnya jika tidak ada bagian lain dari project yang menggunakannya.
// if (!function_exists('unique_id')) {
//     function unique_id() {
//         return uniqid('', true);
//     }
// }

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit(); // Selalu gunakan exit() setelah header redirect untuk menghentikan eksekusi script
}

// adding products in wishlist
if (isset($_POST['add_to_wishlist'])) {
    if ($user_id == '') {
        $warning_msg[] = 'Silakan login terlebih dahulu untuk menambahkan ke wishlist!';
    } else {
        // *** PERBAIKAN: Hapus baris $id = unique_id(); ***
        $product_id = filter_var($_POST['product_id'] ?? '', FILTER_SANITIZE_STRING);

        // Perbaikan backticks pada nama tabel
        $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $varify_wishlist->execute([$user_id, $product_id]);

        // Perbaikan backticks pada nama tabel
        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $cart_num->execute([$user_id, $product_id]);

        if ($varify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'Produk sudah ada di wishlist Anda!';
        } else if ($cart_num->rowCount() > 0) {
            $warning_msg[] = 'Produk sudah ada di keranjang Anda!';
        } else {
            // Perbaikan backticks pada nama tabel, hanya ambil kolom 'price'
            $select_price = $conn->prepare("SELECT `price` FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            if ($fetch_price) { // Pastikan produk ditemukan sebelum insert
                // *** PERBAIKAN: Hapus 'id' dari daftar kolom dan placeholder dari VALUES ***
                // Karena 'id' di-handle oleh AUTO_INCREMENT
                $insert_wishlish = $conn->prepare("INSERT INTO `wishlist` (`user_id`, `product_id`, `price`) VALUES(?,?,?)");
                // *** PERBAIKAN: Hapus $id dari array execute() ***
                $insert_wishlish->execute([$user_id, $product_id, $fetch_price['price']]);
                $success_msg[] = 'Produk berhasil ditambahkan ke wishlist!';
            } else {
                $warning_msg[] = 'Produk tidak ditemukan!'; // Tambahkan pesan error jika product_id tidak valid
            }
        }
    }
}

// adding products in cart
if (isset($_POST['add_to_cart'])) {
    if ($user_id == '') {
        $warning_msg[] = 'Silakan login terlebih dahulu untuk menambahkan ke keranjang!';
    } else {
        // *** PERBAIKAN: Hapus baris $id = unique_id(); ***
        $product_id = filter_var($_POST['product_id'] ?? '', FILTER_SANITIZE_STRING);

        // *** PERBAIKAN: Gunakan FILTER_VALIDATE_INT dan validasi kuantitas ***
        $qty = filter_var($_POST['qty'] ?? 1, FILTER_VALIDATE_INT);
        if ($qty === false || $qty < 1 || $qty > 99) {
            $warning_msg[] = 'Kuantitas tidak valid! Harus antara 1 dan 99.';
            $qty = 1; // Set kembali ke nilai default yang aman
        }

        // Perbaikan backticks pada nama tabel
        $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $varify_cart->execute([$user_id, $product_id]);

        // Perbaikan backticks pada nama tabel
        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $max_cart_items->execute([$user_id]);

        if ($varify_cart->rowCount() > 0) {
            $warning_msg[] = 'Produk sudah ada di keranjang Anda!';
        } else if ($max_cart_items->rowCount() >= 20) { // *** PERBAIKAN: Variabel $max_cart menjadi $max_cart_items ***
            $warning_msg[] = 'Keranjang sudah penuh! Hapus beberapa item atau check out.';
        } else {
            // Perbaikan backticks pada nama tabel, hanya ambil kolom 'price'
            $select_price = $conn->prepare("SELECT `price` FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            if ($fetch_price) { // Pastikan produk ditemukan sebelum insert
                // *** PERBAIKAN: Hapus 'id' dari daftar kolom dan placeholder dari VALUES ***
                // Perbaiki juga typo pada `cart'` menjadi `cart`
                $insert_cart = $conn->prepare("INSERT INTO `cart` (`user_id`, `product_id`, `price`, `qty`) VALUES(?,?,?,?)");
                // *** PERBAIKAN: Hapus $id dari array execute() ***
                $insert_cart->execute([$user_id, $product_id, $fetch_price['price'], $qty]);
                $success_msg[] = 'Produk berhasil ditambahkan ke keranjang!';
            } else {
                $warning_msg[] = 'Produk tidak ditemukan!'; // Tambahkan pesan error jika product_id tidak valid
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
    <title>Green Coffe - product detail page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>product detail</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>product detail</span>
        </div>
        <section class="view_page">
            <?php
            if (isset($_GET['pid'])) {
                $pid = $_GET['pid'];
                // *** PERBAIKAN: Gunakan prepared statement dengan placeholder untuk keamanan dan penanganan tipe data ***
                // Ini mengatasi error "Incorrect integer value" jika $pid bukan integer.
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_products->execute([$pid]);
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                        <form method="post">
                            <img src="image/<?php echo htmlspecialchars($fetch_products['image']); ?>" alt="Product Image">
                            <div class="detail">
                                <div class="price">$<?php echo htmlspecialchars($fetch_products['price']); ?>/-</div>
                                <div class="name"><?php echo htmlspecialchars($fetch_products['name']); ?></div>
                                <div class="detail">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto, est? Commodi molestiae tenetur iure iste laudantium accusantium veniam distinctio, quam sunt. Repellat harum cumque doloremque. Molestias neque voluptates aut sunt.</p>
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($fetch_products['id']); ?>">
                                <div class="button">
                                    <button type="submit" name="add_to_wishlist" class="btn">add to wishlist<i class="bx bx-heart"></i></button>
                                    <input type="hidden" name="qty" value="1" min="1" max="99" class="quantity">
                                    <button type="submit" name="add_to_cart" class="btn">add to cart<i class="bx bx-cart"></i></button>
                                </div>
                            </div>
                        </form>
            <?php
                    } // end while
                } else {
                    echo '<p class="empty">No product found!</p>'; // Pesan jika produk tidak ditemukan
                }
            } else {
                echo '<p class="empty">Product ID not provided!</p>'; // Pesan jika pid tidak ada di URL
            }
            ?>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>

</html>