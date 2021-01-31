<?php
session_start();
require_once "functions/function.php";

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $q = intval($_GET['q']);
    $_SESSION['q'] = intval($_GET['q']);
    get_review_modific($q);
}

function get_review_modific($q) {
    global $pdo, $data_review;

    $stmt = $pdo->query("SELECT * FROM `reviews` WHERE id=$q", PDO::FETCH_ASSOC);
    $data_review = $stmt->fetch();
    return $data_review;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $q = intval($_POST['q']);
    if($_POST['redaction']) {
        set_review_modific();
        echo "<script>window.location.replace('admin.php');</script>";
    } elseif ($_POST['delete']) {
        delete_review();
        echo "<script>window.location.replace('admin.php');</script>";
    }
}

include_once "moderation.html";


