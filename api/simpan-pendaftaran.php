<?php
require 'config.php';

// Mengatur header sebagai JSON
header('Content-Type: application/json');

// Mengambil data JSON dari body request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validasi data (contoh sederhana)
if (empty($data['childFullName']) || empty($data['parentEmail'])) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Menyiapkan statement untuk keamanan (mencegah SQL Injection)
$stmt = $conn->prepare(
    "INSERT INTO pendaftar (childFullName, childDOB, childGender, parentName, parentEmail, parentPhoneNumber, address, additionalInfo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

// Bind parameter ke statement
$stmt->bind_param("ssssssss", 
    $data['childFullName'], 
    $data['childDOB'], 
    $data['childGender'], 
    $data['parentName'], 
    $data['parentEmail'], 
    $data['parentPhoneNumber'], 
    $data['address'], 
    $data['additionalInfo']
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