<?php
require '../function.php';
$cars = select("SELECT * FROM orders");
if (isset($_POST['tambah'])) {
    if (tambah_orders($_POST) > 0) {
        echo "<script>
                alert('Mobil berhasil ditambahkan!');
                document.location.href = 'orders.php';
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
            <h4 class="mb-4">Admin Sepatu</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white<?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? ' active bg-secondary' : '' ?>" href="orders.php">Daftar Mobil</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="orders.php">Order</a>
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
                            <th>Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Address_type</th>
                            <th>Method</th>
                            <th>Product_id</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $or): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($or['user_id']) ?></td>
                                    <td><?= htmlspecialchars($or['number']) ?></td>
                                    <td><?= htmlspecialchars($or['email']) ?></td>
                                    <td><?= htmlspecialchars($or['address']) ?></td>
                                    <td><?= htmlspecialchars($or['address_type']) ?></td>
                                    <td><?= htmlspecialchars($or['method']) ?></td>
                                    <td><?= htmlspecialchars($or['product_id']) ?></td>
                                    <td><?= htmlspecialchars($or['price']) ?></td>
                                    <td><?= htmlspecialchars($or['qty']) ?></td>
                                    <td><?= htmlspecialchars($or['date']) ?></td>
                                    <td><?= htmlspecialchars($or['status']) ?></td>
                                    <td>

                                        <a href="./ubah/ubahorders.php $car['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="./hapus/hapusorders.php $car['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data sepatu.</td>
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
                    </th>

                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahMobilModalLabel">Tambah Mobil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Name</label>
                            <input type="text" class="form-control" id="number" name="number" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Number</label>
                            <input type="text" class="form-control" id="number" name="number" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Address</label>
                            <input type="file" class="form-control" id="addres" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Address_type</label>
                            <input type="text" class="form-control" id="address_type" name="addres_type" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Method</label>
                            <input type="text" class="form-control" id="method" name="method" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Product_id</label>
                            <input type="file" class="form-control" id="product_id" name="product_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Price</label>
                            <input type="text" class="form-control" id="qty" name="qty" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Qty</label>
                            <input type="text" class="form-control" id="qty" name="qty" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Date</label>
                            <input type="file" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Status</label>
                            <input type="file" class="form-control" id="status" name="status" required>
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
 