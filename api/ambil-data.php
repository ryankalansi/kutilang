<?php
require 'config.php';
header('Content-Type: application/json');


$sql = "SELECT id as rowIndex, timestamp, childFullName, childDOB, childGender, parentName, parentEmail, parentPhoneNumber, address, additionalInfo, status_pembayaran FROM pendaftar ORDER BY id DESC";
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