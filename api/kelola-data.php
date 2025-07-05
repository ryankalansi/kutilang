<?php
require 'config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
    case 'edit':
        $data = $input['data'];
        if ($action === 'create') {
            $stmt = $conn->prepare("INSERT INTO pendaftar (nama_lengkap_anak, tanggal_lahir, jenis_kelamin, nama_orang_tua, email, nomor_telepon, alamat, informasi_tambahan, status_pembayaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss",
                $data['nama_lengkap_anak'], $data['tanggal_lahir'], $data['jenis_kelamin'],
                $data['nama_orang_tua'], $data['email'], $data['nomor_telepon'],
                $data['alamat'], $data['informasi_tambahan'], $data['status_pembayaran']
            );
        } else { // Aksi 'edit'
            $rowIndex = $input['rowIndex'];
            $stmt = $conn->prepare("UPDATE pendaftar SET nama_lengkap_anak=?, tanggal_lahir=?, jenis_kelamin=?, nama_orang_tua=?, email=?, nomor_telepon=?, alamat=?, informasi_tambahan=?, status_pembayaran=? WHERE id=?");
            $stmt->bind_param("sssssssssi",
                $data['nama_lengkap_anak'], $data['tanggal_lahir'], $data['jenis_kelamin'],
                $data['nama_orang_tua'], $data['email'], $data['nomor_telepon'],
                $data['alamat'], $data['informasi_tambahan'], $data['status_pembayaran'],
                $rowIndex
            );
        }
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => "Data berhasil di" . ($action === 'create' ? 'tambahkan' : 'update')]);
        } else {
            echo json_encode(['status' => 'error', 'message' => "Gagal: " . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'deleteRow':
        $rowIndex = $_GET['rowIndex'] ?? 0;
        $stmt = $conn->prepare("DELETE FROM pendaftar WHERE id = ?");
        $stmt->bind_param("i", $rowIndex);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data: ' . $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
        break;
}

$conn->close();
?>