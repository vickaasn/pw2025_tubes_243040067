<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6fa;
        }

        .sidebar {
            background-color: #6c5ce7;
            color: white;
            min-height: 100vh;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover {
            background-color: #5e50e0;
        }

        .table-avatar {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .btn-add {
            background-color: #6c5ce7;
            color: white;
        }

        .btn-add:hover {
            background-color: #574bd6;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar pt-4">
                <h5 class="text-center mb-4">Admin Panel</h5>
                <a href="users.php">Users</a>
                <a href="cart.php">Cart</a>
                <a href="orders.php">Orders</a>
                <a href="products.php">Products</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Product List</h3>
                    <a href="tambah/add_product.php" class="btn btn-add"><i class="bi bi-plus-circle"></i> Add New Product</a>
                </div>

                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Detail</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($products as $product): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><img src="../../img/<?= $product['image'] ?>" class="table-avatar" alt=""></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td><?= nl2br(htmlspecialchars($product['product_detail'])) ?></td>
                                <td>
                                    <a href="ubah/edit_product.php?id=<?= $product['id'] ?>" class="text-warning me-2"><i class="bi bi-pencil-square"></i></a>
                                    <a href="hapus/delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Hapus produk ini?')" class="text-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>