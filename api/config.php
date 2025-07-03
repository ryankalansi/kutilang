<?php
// Mengatur zona waktu
date_default_timezone_set('Asia/Jakarta');

// Mengatur header untuk memperbolehkan akses dari mana saja (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Konfigurasi Database
$db_host = 'localhost';
$db_user = 'root'; // Default username XAMPP
$db_pass = '';     // Default password XAMPP
$db_name = 'db_kutilang';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>