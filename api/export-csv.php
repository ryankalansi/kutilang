<?php
require 'config.php';

// Nama file yang akan di-download
$filename = "data_pendaftar_tk_kutilang_" . date('Y-m-d') . ".csv";

// Set header untuk memberitahu browser bahwa ini adalah file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Buka output stream PHP
$output = fopen('php://output', 'w');

// Tulis header kolom di file CSV
fputcsv($output, array('ID', 'Tanggal Pendaftaran', 'Nama Anak', 'Tgl Lahir Anak', 'Gender Anak', 'Nama Orang Tua', 'Email', 'No Telepon', 'Alamat', 'Info Tambahan'));

// Ambil data dari database
$sql = "SELECT id, waktu_pendaftaran, 
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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Tulis setiap baris data ke file CSV
        fputcsv($output, $row);
    }
}

fclose($output);
$conn->close();
exit();
?>