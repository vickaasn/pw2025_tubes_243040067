<?php
require 'function.php';
$cars = select("SELECT * FROM products");
if (isset($_POST['tambah'])) {
    if (tambah_produk($_POST) > 0) {
        echo "<script>
                alert('Mobil berhasil ditambahkan!');
                document.location.href = 'jual.php';
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
    <title>Daftar Mobil Dijual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <nav class="bg-dark text-white p-3 vh-100" style="width: 220px; min-width: 200px;">
            <h4 class="mb-4">Admin Mobil</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white<?= basename($_SERVER['PHP_SELF']) == 'jual.php' ? ' active bg-secondary' : '' ?>" href="jual.php">Daftar Mobil</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white<?= basename($_SERVER['PHP_SELF']) == 'tambahmobil.php' ? ' active bg-secondary' : '' ?>" href="tambahmobil.php">Tambah Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="flex-grow-1">
            <div class="container mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Daftar Mobil Dijual</h2>
                    <!-- Tombol trigger modal -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahMobilModal">
                        + Tambah Mobil
                    </button>
                </div>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Mobil</th>
                            <th>Merk</th>
                            <th>Tahun</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cars)): ?>
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $car['name'] ?></td>
                                    <td><?= $car['price'] ?></td>
                                    <td><?= $car['image'] ?></td>
                                    <td><?= $car['product_detail'] ?></td>
                                    <td>
                                        <a href="editmobil.php?id=<?= $car['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="hapusmobil.php?id=<?= $car['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data mobil.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Mobil -->
        <div class="modal fade" id="tambahMobilModal" tabindex="-1" aria-labelledby="tambahMobilModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action=" " method="post" enctype="multipart/form-data" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahMobilModalLabel">Tambah Mobil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Mobil</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="merk" class="form-label">Merk</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label"></label>
                            <input type="number" class="form-control" id="harga" name="product_detail" required>
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
    <!-- Bootstrap JS (wajib untuk modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>