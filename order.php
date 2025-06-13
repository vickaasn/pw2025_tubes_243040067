<?php
include 'components/connection.php';
session_start();

// Cek user login
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: login.php");
    exit;
}

// Logout handler
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
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
    <title>Green Coffee - Order Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;600&family=Yeseva+One&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>My Orders</h1>
        </div>

        <div class="title2">
            <a href="home.php">Home</a> <span>/ Orders</span>
        </div>

        <section class="orders">
            <div class="title">
                <h1>My Order</h1>
                <p>Berikut adalah pesanan Anda yang telah dilakukan melalui toko kami.</p>
            </div>

            <div class="box-container">
                <?php
                $select_orders = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY date DESC");
                $select_orders->execute([$user_id]);

                if ($select_orders->rowCount() > 0) {
                    while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {

                        $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
                        $select_product->execute([$fetch_order['product_id']]);

                        if ($select_product->rowCount() > 0) {
                            $product = $select_product->fetch(PDO::FETCH_ASSOC);

                            $status_color = match ($fetch_order['status']) {
                                'delivered' => 'green',
                                'canceled' => 'red',
                                default => 'orange',
                            };
                ?>
                            <div class="box" <?php if ($fetch_order['status'] === 'canceled') echo 'style="border: 2px solid red;"'; ?>>
                                <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
                                    <p class="date"><i class="bi bi-calendar-fill"></i> <span><?= htmlspecialchars($fetch_order['date']); ?></span></p>
                                    <img src="Assets/img/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                                    <div class="row">
                                        <h3 class="name"><?= htmlspecialchars($product['name']); ?></h3>
                                        <p class="price">Price: Rp<?= number_format($fetch_order['price'], 0, ',', '.') ?> x <?= $fetch_order['qty']; ?></p>
                                        <p class="status" style="color:<?= $status_color; ?>"><?= htmlspecialchars($fetch_order['status']); ?></p>
                                    </div>
                                </a>
                            </div>
                <?php
                        }
                    }
                } else {
                    echo '<p class="empty">No orders found. Please place an order first.</p>';
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