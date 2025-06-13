<?php
include 'components/connection.php';
session_start();

$warning_msg = [];
$success_msg = [];
$message = [];
$cart_items = []; // Array untuk menyimpan detail item dari keranjang
$grand_total = 0; // Untuk menghitung total harga semua item di keranjang

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    $message[] = 'Harap login untuk melanjutkan checkout!';
    // header('location: login.php'); // Aktifkan ini jika login wajib
    // exit();
}

// --- Logika untuk mengambil item dari keranjang ---
if ($user_id != '') { // Hanya jika user sudah login
    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart->execute([$user_id]);

    if ($select_cart->rowCount() > 0) {
        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$fetch_cart['product_id']]);
            if ($select_product->rowCount() > 0) {
                $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
                $sub_total = $fetch_product['price'] * $fetch_cart['qty'];
                $grand_total += $sub_total;

                $cart_items[] = [
                    'product_id' => $fetch_cart['product_id'],
                    'name' => $fetch_product['name'],
                    'price' => $fetch_product['price'], // Harga per item
                    'qty' => $fetch_cart['qty'],
                    'sub_total' => $sub_total
                ];
            }
        }
    } else {
        $message[] = 'Keranjang Anda kosong!';
    }
} else {
    $message[] = 'Keranjang tidak dapat diakses tanpa login.';
}


// --- Logika untuk proses checkout (jika form checkout disubmit) ---
if (isset($_POST['place_order'])) {
    if ($user_id == '') {
        $message[] = 'Harap login untuk melakukan checkout!';
    } else if (empty($cart_items)) { // Pastikan ada item di keranjang sebelum checkout
        $message[] = 'Tidak ada produk di keranjang untuk checkout!';
    } else {
        // Ambil data dari form
        if (isset($_POST['name']) && isset($_POST['number']) && isset($_POST['email']) && isset($_POST['method']) && isset($_POST['address'])) {
            $name = htmlspecialchars($_POST['name']);
            $number = htmlspecialchars($_POST['number']);
            $email = htmlspecialchars($_POST['email']);
            $method = htmlspecialchars($_POST['method']);
            $address = htmlspecialchars($_POST['address']);
            $address_type = 'home'; // Nilai default, tambahkan input di form jika perlu pilihan

            // Masukkan setiap item dari keranjang ke tabel orders
            foreach ($cart_items as $item) {
                $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, address, address_type, method, product_id, price, qty, `date`, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                $insert_order->execute([
                    $user_id,
                    $name,
                    $number,
                    $email,
                    $address,
                    $address_type,
                    $method,
                    $item['product_id'],
                    $item['sub_total'], // Menyimpan sub_total untuk setiap item sebagai 'price' di tabel orders
                    $item['qty'],
                    date('Y-m-d H:i:s'),
                    'pending'
                ]);
            }

            // Opsional: Hapus item dari keranjang setelah berhasil diorder
            $empty_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $empty_cart->execute([$user_id]);

            $success_msg[] = 'Pesanan berhasil ditempatkan!';
            // Anda bisa mengarahkan pengguna ke halaman konfirmasi pesanan setelah ini
            // header('location: order_confirmed.php');
            // exit();
        } else {
            $message[] = 'Data pengiriman form tidak lengkap. Harap lengkapi semua bidang yang diperlukan.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Yeseva+One&display=swap" rel="stylesheet">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Checkout</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>checkout</span>
        </div>

        <section class="checkout">
            <?php
            // Menampilkan pesan warning/success/error
            if (!empty($message)) {
                foreach ($message as $msg) {
                    echo '<p class="error-msg">' . htmlspecialchars($msg) . '</p>';
                }
            }
            if (!empty($warning_msg)) {
                foreach ($warning_msg as $msg) {
                    echo '<p class="warning-msg">' . htmlspecialchars($msg) . '</p>';
                }
            }
            if (!empty($success_msg)) {
                foreach ($success_msg as $msg) {
                    echo '<p class="success-msg">' . htmlspecialchars($msg) . '</p>';
                }
            }

            // Tampilkan ringkasan pesanan dari keranjang
            if (!empty($cart_items)) {
                echo '<div class="product-details">';
                echo '<h2>Ringkasan Pesanan Anda:</h2>';
                foreach ($cart_items as $item) {
                    echo '<p>' . htmlspecialchars($item['name']) . ' (x' . htmlspecialchars($item['qty']) . ') - $' . htmlspecialchars($item['sub_total']) . '</p>';
                }
                echo '<p><strong>Total Keseluruhan: $' . htmlspecialchars($grand_total) . '/-</strong></p>';

                // Form checkout yang lebih lengkap
                echo '<form action="" method="post" class="checkout-form">';
                // Tidak perlu hidden input product_id_post lagi karena kita proses dari cart_items

                echo '<div class="flex">';
                echo '<div class="box">';
                echo '<p>Nama Lengkap <span>*</span></p>';
                echo '<input type="text" name="name" required class="input">';
                echo '<p>Nomor Telepon <span>*</span></p>';
                echo '<input type="number" name="number" required class="input">';
                echo '<p>Email <span>*</span></p>';
                echo '<input type="email" name="email" required class="input">';
                echo '</div>';

                echo '<div class="box">';
                echo '<p>Metode Pembayaran <span>*</span></p>';
                echo '<select name="method" class="input">';
                echo '<option value="cash on delivery">Cash On Delivery</option>';
                echo '<option value="credit card">Credit Card</option>';
                echo '<option value="paypal">Paypal</option>';
                echo '<option value="bank transfer">Bank Transfer</option>';
                echo '</select>';
                echo '<p>Alamat Lengkap <span>*</span></p>';
                echo '<input type="text" name="address" required class="input">';
                // Kuantitas tidak perlu di form ini karena sudah dari keranjang
                echo '</div>';
                echo '</div>';

                echo '<button type="submit" name="place_order" class="btn">Place Order</button>';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<p class="empty">Tidak ada produk di keranjang Anda untuk checkout.</p>';
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