<?php
require 'config.php';

// Mengatur header sebagai JSON
header('Content-Type: application/json');

// Mengambil data JSON dari body request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validasi data (contoh sederhana)
if (empty($data['nama_lengkap_anak']) || empty($data['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Menyiapkan statement untuk keamanan (mencegah SQL Injection)
// PERBAIKAN DI SINI: Tambahkan tanda kurung () di sekitar nama kolom
$stmt = $conn->prepare(
    "INSERT INTO pendaftar (nama_lengkap_anak, 
            tanggal_lahir, 
            jenis_kelamin, 
            nama_orang_tua, 
            email, 
            nomor_telepon, 
            alamat, 
            informasi_tambahan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

// Pengecekan apakah prepare berhasil
if ($stmt === false) {
    // Kirim pesan error dalam format JSON jika prepare gagal
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan statement SQL: ' . $conn->error]);
    exit;
}


// Bind parameter ke statement
$stmt->bind_param("ssssssss", 
    $data['nama_lengkap_anak'], 
    $data['tanggal_lahir'], 
    $data['jenis_kelamin'], 
    $data['nama_orang_tua'], 
    $data['email'], 
    $data['nomor_telepon'], 
    $data['alamat'], 
    $data['informasi_tambahan']
);

// Eksekusi statement dan beri respons
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil disimpan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>