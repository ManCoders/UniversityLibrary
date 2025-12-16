<?php
session_start();

$token = $_GET['token'] ?? null;

if (!$token || !isset($_SESSION['pdf_tokens'][$token])) {
    echo json_encode(['status' => 'expired']);
    exit;
}

$tokenData = $_SESSION['pdf_tokens'][$token];

if ($tokenData['expires'] >= time()) {
    echo json_encode([
        'status' => 'valid',
        'file' => $tokenData['file'],
        'title' => $tokenData['book_titlev'] ?? 'Unknown Title',
        'author' => $tokenData['book_author'] ?? 'Unknown Author'
    ]);
} else {
    unset($_SESSION['pdf_tokens'][$token]);
    echo json_encode(['status' => 'expired']);
}
