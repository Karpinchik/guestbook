<?php
require_once "conf/db_data.php";

function get_admin_filter_data($sql){
    global $pdo;
    if ($pdo) {
        $stmt = $pdo->query($sql, PDO::FETCH_ASSOC);
//        if (empty($result)) echo 'нет в базе отзывов';
        return $stmt->fetchAll();
    } else {
        echo "нет подключение к бд";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM `reviews`";
    $result = get_admin_filter_data($sql);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if($_POST['filter-button-reset']){
        echo "<script>window.location.replace('admin.php');</script>";
    }

    if ($_POST['filter-button']) {

        $published = $_POST['published-chb'] == 'on' ? 1 : 0;
        $answer = $_POST['answer-chb'] == 'on' ? 1 : NULL;

        if($_POST['strict-chb']) {
            if ($answer == 1) {
                $sql = "SELECT * FROM `reviews` WHERE answer IS NOT NULL ";
                $result = get_admin_filter_data($sql);
            } else if ($published == 1) {
                $sql = "SELECT * FROM `reviews` WHERE display=$published";
                $result = get_admin_filter_data($sql);
            }
        } else {
            if ($answer == 1) {
                $sql = "SELECT * FROM `reviews` WHERE display=$published OR answer IS NOT NULL ";
                $result = get_admin_filter_data($sql);
            } else if ($answer == NULL) {
                $sql = "SELECT * FROM `reviews` WHERE display=$published OR answer IS NULL";
                $result = get_admin_filter_data($sql);
            }
        }
    }
}

include_once "admin.html";