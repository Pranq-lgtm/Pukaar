<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ngo') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['is_online'])) {
    $is_online = $data['is_online'] ? 'TRUE' : 'FALSE';
    
    try {
        $stmt = $pdo->prepare("UPDATE ngo_profiles SET is_online = ? WHERE user_id = ?");
        $stmt->execute([$is_online, $_SESSION['user_id']]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
?>