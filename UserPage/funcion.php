<?php
$db = mysqli_connect('localhost', 'root', '', 'pw2025_tubes_243040067');
if (!$db) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

function select($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    if (!$result) {
        die('Query error: ' . mysqli_error($db));
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function tambah_produk($data)
{
    global $db;
    $name = $data['name'];
    $price = $data['price'];
    $image = $data['image'];
    $product_detail = $data['product_detail'];
    $query = "INSERT INTO car (name, price, image, product_detail) VALUES (null,'$name', '$price', '$image', '$product_detail')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}
