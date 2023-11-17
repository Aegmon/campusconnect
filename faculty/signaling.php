<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    switch ($data['action']) {
        case 'storeOffer':
            $_SESSION['offer'][$data['userId']] = $data['offer'];
            break;

        case 'getOffer':
            $offer = isset($_SESSION['offer'][$data['userId']]) ? $_SESSION['offer'][$data['userId']] : null;
            echo json_encode(['offer' => $offer]);
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
