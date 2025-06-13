<?php
// Koneksi ke database pakai PDO
$host = 'localhost';
$db_name = 'pw2025_tubes_243040067';
$db_user = 'root';
$db_pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Fungsi SELECT
function select($query)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi generate ID unik (jika diperlukan)
function unique_id()
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = strlen($chars);
    $result = '';
    for ($i = 0; $i < 20; $i++) {
        $result .= $chars[mt_rand(0, $length - 1)];
    }
    return $result;
}

// Fungsi tambah cart
function tambah_cart($data)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, price, qty) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $data['user_id'],
        $data['product_id'],
        $data['price'],
        $data['qty']
    ]);
    return $stmt->rowCount();
}

// Fungsi edit cart
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
    return $stmt->rowCount();
}

// Fungsi hapus cart
function hapus_cart($id_cart)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$id_cart]);
    return $stmt->rowCount();
}


// Fungsi tambah cart
function tambah_orders($data)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, number, email, addres, address_type, method, product_id, price, qty, date, status) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['user_id'],
        $data['name'],
        $data['number'],
        $data['email'],
        $data['addres'],
        $data['address_type'],
        $data['method'],
        $data['product_id'],
        $data['price'],
        $data['qty'],
        $data['date'],
        $data['status']
    ]);
    return $stmt->rowCount();
}

function edit_orders($id, $user_id, $name, $number, $email, $addres, $address_type, $method, $product_id, $price, $qty, $date, $status)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET user_id=?, name=?, number=?, email=?, addres=?, address_type=?, method=?, product_id=?, price=?, qty=?, date=?, status=? WHERE id = ?");
    $stmt->execute([
        $user_id,
        $name,
        $number,
        $email,
        $addres,
        $address_type,
        $method,
        $product_id,
        $price,
        $qty,
        $date,
        $status,
        $id
    ]);
    return $stmt->rowCount();
}


// Fungsi hapus cart
function hapus_orders($id_cart)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->execute([$id_cart]);
    return $stmt->rowCount();
}
