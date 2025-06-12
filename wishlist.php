<?php
include 'components/connection.php';
session_start();

// Inisialisasi array pesan jika belum ada, penting untuk sweetalert
if (!isset($warning_msg)) {
    $warning_msg = [];
}
if (!isset($success_msg)) {
    $success_msg = [];
}
if (!isset($message)) { // Jika Anda menggunakan $message untuk sweetalert
    $message = [];
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

// adding products in cart from wishlist page
if (isset($_POST['add_to_cart'])) {
    if ($user_id == '') {
        $warning_msg[] = 'Silakan login terlebih dahulu untuk menambahkan ke keranjang!';
    } else {
        // HAPUS BARIS INI: $id = unique_id(); karena ID akan di-generate oleh AUTO_INCREMENT
        $product_id = filter_var($_POST['product_id'] ?? '', FILTER_SANITIZE_NUMBER_INT);

        // Kuantitas default untuk wishlist ke cart biasanya 1
        $qty = 1;
        // Tidak perlu filter_var untuk $qty jika sudah dijamin 1
        // $qty = filter_var($qty, FILTER_VALIDATE_INT); // Ini juga opsional jika qty selalu 1

        $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?"); // Perbaiki backticks
        $varify_cart->execute([$user_id, $product_id]);

        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?"); // Perbaiki backticks
        $max_cart_items->execute([$user_id]);

        if ($varify_cart->rowCount() > 0) {
            $warning_msg[] = 'Produk sudah ada di keranjang Anda!'; // PERBAIKI: pesan ini untuk cart, bukan wishlist
        } else if ($max_cart_items->rowCount() >= 20) { // PERBAIKI: variabel $max_cart menjadi $max_cart_items
            $warning_msg[] = 'Keranjang sudah penuh! Hapus beberapa item atau check out.';
        } else {
            $select_price = $conn->prepare("SELECT `price` FROM `products` WHERE id = ? LIMIT 1"); // Perbaiki backticks
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            if ($fetch_price) { // Pastikan produk ditemukan
                // HAPUS 'id' dari daftar kolom dan placeholder dari VALUES karena ID AUTO_INCREMENT
                $insert_cart = $conn->prepare("INSERT INTO `cart` (`user_id`, `product_id`, `price`, `qty`) VALUES(?,?,?,?)"); // Perbaiki backticks dan daftar kolom/placeholder
                // HAPUS $id dari array execute()
                $insert_cart->execute([$user_id, $product_id, $fetch_price['price'], $qty]);
                $success_msg[] = 'Produk berhasil ditambahkan ke keranjang!';
            } else {
                $warning_msg[] = 'Produk tidak ditemukan!';
            }
        }
    }
}

// delete item from wishlist
if (isset($_POST['delete_item'])) {
    $wishlist_id = filter_var($_POST['wishlist_id'], FILTER_SANITIZE_NUMBER_INT); // Lebih spesifik untuk ID

    $varify_delete_items = $conn->prepare("SELECT * FROM `wishlist` WHERE `id` = ?"); // Perbaiki backticks
    $varify_delete_items->execute([$wishlist_id]);

    if ($varify_delete_items->rowCount() > 0) {
        $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE `id` = ?"); // Perbaiki backticks, nama variabel lebih jelas
        $delete_wishlist_item->execute([$wishlist_id]);
        $success_msg[] = "Item wishlist berhasil dihapus!";
    } else {
        $warning_msg[] = 'Item wishlist sudah dihapus!'; // Pesan lebih jelas
    }
}

// empty wishlist (opsional, jika Anda ingin ada tombol untuk mengosongkan semua wishlist)
if (isset($_POST['empty_wishlist'])) {
    $varify_empty_item = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
    $varify_empty_item->execute([$user_id]);

    if ($varify_empty_item->rowCount() > 0) {
        $delete_all_wishlist_items = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
        $delete_all_wishlist_items->execute([$user_id]);
        $success_msg[] = "Wishlist berhasil dikosongkan!";
    } else {
        $warning_msg[] = 'Wishlist sudah kosong!';
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
    <title>Green Coffe - My Wishlist</title>
</head>

<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>my wishlist</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>wishlist</span>
        </div>
        <section class="products">
            <h1 class="title">products added in wishlist</h1>
            <div class="box-container">
                <?php
                // Grand total di wishlist biasanya tidak ada karena hanya daftar produk, bukan total harga
                // $grand_total = 0; // Anda bisa hapus baris ini jika tidak digunakan
                $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?"); // Perbaiki backticks
                $select_wishlist->execute([$user_id]);
                if ($select_wishlist->rowCount() > 0) {
                    while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                        // PERBAIKI: Query untuk products, gunakan backticks yang benar dan hapus tanda '?' yang salah posisi
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$fetch_wishlist['product_id']]);
                        if ($select_products->rowCount() > 0) {
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);

                ?>
                            <form method="post" action="" class="box">
                                <input type="hidden" name="wishlist_id" value="<?= htmlspecialchars($fetch_wishlist['id']); ?>">
                                <img src="image/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Product Image">
                                <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                                <div class="flex">
                                    <p class="price">price $<?= htmlspecialchars($fetch_products['price']); ?>/-</p>
                                </div>
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                                <div class="button">
                                    <button type="submit" name="add_to_cart" class="btn">add to cart<i class="bx bx-cart"></i></button>
                                    <a href="view_page.php?pid=<?php echo htmlspecialchars($fetch_products['id']); ?>" class="btn">view product<i class="bx bxs-show"></i></a>
                                    <button type="submit" name="delete_item" class="btn" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari wishlist?')">delete<i class="bx bx-x"></i></button>
                                </div>
                            </form>
                <?php
                            // grand_total di wishlist biasanya tidak diperlukan
                            // $grand_total += $fetch_wishlist['price'];
                        } else {
                            echo '<p class="empty">Produk tidak ditemukan!</p>';
                        }
                    }
                } else {
                    echo '<p class="empty">Tidak ada produk di wishlist!</p>';
                }
                ?>
            </div>
            <?php
            // Bagian empty wishlist
            // Anda bisa menambahkan tombol "empty wishlist" di sini
            if ($select_wishlist->rowCount() > 0) { // Hanya tampilkan tombol jika ada item di wishlist
            ?>
                <div class="wishlist-total">
                    <form method="post">
                        <button type="submit" name="empty_wishlist" class="btn" onclick="return confirm('Apakah Anda yakin ingin mengosongkan semua item dari wishlist?')">empty wishlist</button>
                    </form>
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