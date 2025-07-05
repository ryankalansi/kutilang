<?php
require 'config.php';
header('Content-Type: application/json');


$sql = "SELECT 
            id as rowIndex, 
            waktu_pendaftaran, 
            nama_lengkap_anak, 
            tanggal_lahir, 
            jenis_kelamin, 
            nama_orang_tua, 
            email, 
            nomor_telepon, 
            alamat, 
            informasi_tambahan, 
            status_pembayaran 
        FROM pendaftar 
        ORDER BY id DESC";

$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode(['status' => 'success', 'data' => $data]);
$conn->close();
?>