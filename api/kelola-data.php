<?php
require 'config.php';
header('Content-Type: application/json');

// Mengambil data JSON dari body request
$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $data = $input['data'];
        $stmt = $conn->prepare("INSERT INTO pendaftar (childFullName, childDOB, childGender, parentName, parentEmail, parentPhoneNumber, address, additionalInfo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", 
            $data['childFullName'], $data['childDOB'], $data['childGender'], 
            $data['parentName'], $data['parentEmail'], $data['parentPhoneNumber'], 
            $data['address'], $data['additionalInfo']
        );
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data baru berhasil ditambahkan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan data: ' . $stmt->error]);
        }
        $stmt->close();
        break;

    case 'edit':
        $data = $input['data'];
        $rowIndex = $input['rowIndex'];
        $stmt = $conn->prepare("UPDATE pendaftar SET childFullName=?, childDOB=?, childGender=?, parentName=?, parentEmail=?, parentPhoneNumber=?, address=?, additionalInfo=? WHERE id=?");
        $stmt->bind_param("ssssssssi", 
            $data['childFullName'], $data['childDOB'], $data['childGender'], 
            $data['parentName'], $data['parentEmail'], $data['parentPhoneNumber'], 
            $data['address'], $data['additionalInfo'], $rowIndex
        );
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diupdate']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate data: ' . $stmt->error]);
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