<?php
require_once 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inisialisasi $user_id
$user_id = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// Inisialisasi dan hitung wishlist items
$total_wishlist_items = 0; // Default value
if ($user_id !== null) { // Hanya jalankan query jika user_id ada
    $count_wishlist_items = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
    $count_wishlist_items->execute([$user_id]);
    $total_wishlist_items = $count_wishlist_items->rowCount();
}

// Inisialisasi dan hitung cart items
$total_cart_items = 0; // Default value
if ($user_id !== null) { // Hanya jalankan query jika user_id ada
    $count_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $count_cart_items->execute([$user_id]);
    $total_cart_items = $count_cart_items->rowCount();
}

?>
<header class="header">
    <div class="flex">
        <!-- Logo -->
        <a href="home.php" class="logo">
            <img src="Assets/img/logobrand.jpg" alt="Sneakypair Logo">
        </a>

        <!-- Navigasi Utama -->
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="C:\laragon\www\pw2025_tubes_243040067\view_product.php">products</a>
            <a href="order.php">order</a>
            <a href="about.php">about us</a>
            <a href="contact.php">contact us</a>
        </nav>

        <!-- Ikon (User, Wishlist, Cart, Menu) -->
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <a href="wishlist.php" class="cart-btn">
                <i class="bx bx-heart"></i>
                <sup><?= $total_wishlist_items ?></sup>
            </a>
            <a href="cart.php" class="cart-btn">
                <i class="bx bx-cart-download"></i>
                <sup><?= $total_cart_items ?></sup>
            </a>
            <!-- Icon menu untuk mobile, ukurannya bisa diatur di CSS -->
            <i class="bx bx-menu" id="menu-btn"></i>
        </div>

        <!-- User Box (Dropdown/Pop-up) -->
        <div class="user-box">
            <?php
            if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
                // Jika user sudah login
                echo '<p>username : <span>' . htmlspecialchars($_SESSION['user_name']) . '</span></p>';
                echo '<p>Email : <span>' . htmlspecialchars($_SESSION['user_email']) . '</span></p>';
                echo '<form method="post" action="">'; // Action bisa kosong jika di file yang sama
                echo '<button type="submit" name="logout" class="logout-btn btn">log out</button>';
                echo '</form>';
            } else {
                // Jika user belum login
                echo '<p>username : <span>Guest</span></p>';
                echo '<p>Email : <span>N/A</span></p>';
                echo '<a href="login.php" class="btn">login</a>';
                echo '<a href="register.php" class="btn">register</a>';
            }
            ?>
        </div>
    </div>
</header>