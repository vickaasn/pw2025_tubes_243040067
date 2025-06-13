<?php
require '../function.php';
$cars = select("SELECT * FROM cart");
if (isset($_POST['tambah'])) {
    if (tambah_cart($_POST) > 0) {
        echo "<script>
                alert('Mobil berhasil ditambahkan!');
                document.location.href = 'cart.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan mobil!');
              </script>";
    }
}


$no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Sepatu Dijual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <nav class="bg-dark text-white p-3 vh-100" style="width: 220px; min-width: 200px;">
            <h4 class="mb-4">Admin</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white<?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? ' active bg-secondary' : '' ?>" href="cart.php">Daftar Sepatu</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="cart.php">Order</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="flex-grow-1">
            <div class="container mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Daftar Sepatu Dijual</h2>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahMobilModal">
                        + Tambah Cart
                    </button>
                </div>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Product ID</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cars)): ?>
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($car['user_id']) ?></td>
                                    <td><?= htmlspecialchars($car['product_id']) ?></td>
                                    <td><?= htmlspecialchars($car['price']) ?></td>
                                    <td><?= htmlspecialchars($car['qty']) ?></td>
                                    <td>

                                        <a href="./ubah/ubahcart.php $car['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="./hapus/hapuscart.php $car['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Mobil -->
        <div class="modal fade" id="tambahMobilModal" tabindex="-1" aria-labelledby="tambahMobilModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="post" enctype="multipart/form-data" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahMobilModalLabel">Tambah Sepatu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Sepatu</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Mobil</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="product_detail" class="form-label">Detail Mobil</label>
                            <textarea class="form-control" id="product_detail" name="product_detail" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
 