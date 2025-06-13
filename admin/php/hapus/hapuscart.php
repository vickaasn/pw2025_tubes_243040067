<?php
function edit_cart($data, $id_cart)
{
    global $conn;

    $stmt = $conn->prepare("UPDATE cart SET user_id = ?, product_id = ?, price = ?, qty = ? WHERE id = ?");
    $stmt->execute([
        $data['user_id'],
        $data['product_id'],
        $data['price'],
        $data['qty'],
        $id_cart
    ]);

    return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh
}
