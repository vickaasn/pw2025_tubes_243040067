<?php
$db_name = 'mysql:host=localhost;dbname=pw2025_tubes_243040067';
$db_user = 'root';
$db_password = '';

$conn = new PDO($db_name, $db_user, $db_password);


// Fungsi untuk menghasilkan ID unik acak
function unique_id()
{
    // Karakter yang akan digunakan untuk membentuk ID unik (angka dan huruf besar/kecil)
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Hitung panjang string karakter
    $charLength = strlen($chars);

    // Inisialisasi string acak 
    $randomString = '';

    // Loop untuk membuat ID sepanjang 20 karakter
    for ($i = 0; $i < 20; $i++) {
        // Ambil karakter acak dari $chars dan tambahkan ke $randomString
        $randomString .= $chars[mt_rand(0, $charLength - 1)];
    }

    // Kembalikan ID unik yang telah dibuat
    return $randomString;
}
