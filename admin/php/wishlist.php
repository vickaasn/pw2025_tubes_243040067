<?php
require '../components/connection.php';

$query = "
  SELECT wishlist.*, users.name AS user_name, users.email, 
         products.name AS product_name, products.image
  FROM wishlist
  JOIN users ON wishlist.user_id = users.id
  JOIN products ON wishlist.product_id = products.id
";
$stmt = $conn->prepare($query);
$stmt->execute();
$wishlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Wishlist</title>
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
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 5px;
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
        <a href="wishlist.php">Wishlist</a>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3>Wishlist Items</h3>
          <a href="#" class="btn btn-outline-secondary"><i class="bi bi-download"></i> Export</a>
        </div>

        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Email</th>
              <th>Product</th>
              <th>Image</th>
              <th>Price</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1;
            foreach ($wishlist as $item): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($item['user_name']) ?></td>
                <td><?= htmlspecialchars($item['email']) ?></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><img src="../../img/<?= $item['image'] ?>" class="table-avatar" alt=""></td>
                <td>$<?= number_format($item['price'], 2) ?></td>
                <td>
                  <a href="hapus/delete_wishlist.php?id=<?= $item['id'] ?>" onclick="return confirm('Hapus dari wishlist?')" class="text-danger"><i class="bi bi-trash"></i></a>
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