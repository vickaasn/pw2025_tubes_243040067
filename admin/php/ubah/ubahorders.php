<?php
require('../function.php');

$id = (int)$_GET['id'];
$cart_data = select("SELECT * FROM cart WHERE id = $id");
$cart = $cart_data[0]; // Ambil baris pertama

if (isset($_POST['submit'])) {
    if (edit_cart($_POST, $id) > 0) {
        echo "<script>
            alert('Data cart berhasil diubah.');
            window.location.href = 'cart.php';
        </script>";
    } else {
        echo "<script>alert('Data cart gagal diubah.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height:100vh; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);">
        <div class="card p-4 shadow-lg border-0" style="width: 500px; border-radius: 20px;">
            <div class="text-center mb-4">
                <i class="bi bi-cart-fill" style="font-size: 3rem; color: #0d6efd;"></i>
                <h3 class="mt-2 mb-0 fw-bold">Edit Data Cart</h3>
                <small class="text-muted">Perbarui data keranjang</small>
            </div>
            <form method="post" autocomplete="off">
                <input type="hidden" name="id" value="<?= htmlspecialchars($cart['id']); ?>">

                <div class="mb-3">
                    <label for="user_id" class="form-label fw-semibold">User ID</label>
                    <input id="user_id" name="user_id" required class="form-control form-control-lg" type="number" value="<?= htmlspecialchars($cart['user_id']) ?>">
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label fw-semibold">Product ID</label>
                    <input id="product_id" name="product_id" required class="form-control form-control-lg" type="number" value="<?= htmlspecialchars($cart['product_id']) ?>">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold">Harga</label>
                    <input id="price" name="price" required class="form-control form-control-lg" type="number" value="<?= htmlspecialchars($cart['price']) ?>">
                </div>

                <div class="mb-3">
                    <label for="qty" class="form-label fw-semibold">Jumlah (Qty)</label>
                    <input id="qty" name="qty" required class="form-control form-control-lg" type="number" value="<?= htmlspecialchars($cart['qty']) ?>">
                </div>

                <button class="btn btn-primary w-100 py-2 fw-bold" type="submit" name="submit">
                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>