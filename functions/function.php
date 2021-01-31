<?php
include_once "conf/db_data.php";

function set_reviews()
{

    global $pdo;
    if ($pdo) {
        $sql = "INSERT INTO `reviews`(title, message, name, phone, email, display, answer) 
                VALUES (:title, :message, :name, :phone, :email, :display, :answer)";
        $stmt = $pdo->prepare($sql);

        $params = [
            ':title' => $_POST['title-review'],
            ':message' => $_POST['message-review'],
            ':name' => $_POST['name-review'],
            ':phone' => $_POST['phone-review'],
            ':email' => filter_var($_POST['email-review'], FILTER_VALIDATE_EMAIL),
            ':display' => 0,
            ':answer' => null
        ];

        if ($stmt->execute($params)) {
            echo "<script>alert('отзыв созранен и находится на модерации.');</script>";
        } else {
            echo 'ваш отзыв не записан в базу. попробуйте еще раз';
        }
    } else {
        echo "не подключились к базе";
    }
}


function set_review_modific(){
    global $pdo;
    if ($pdo) {
        $chb_value = $_POST['display-moderation'] == 'on' ? 1 : 0;
        $chb_value = intval($chb_value);
        $params = [
            $_POST['message-moderation'],
            $chb_value,
            $_POST['answer-moderation']
        ];

        $item_review = $_SESSION['q'];
        $sql = "UPDATE `reviews` SET message=?, display=?, answer=? WHERE id=$item_review";
        $stmt = $pdo->prepare($sql);
        $ok_moderation = $stmt->execute($params);
        if($ok_moderation) {
            echo "<script>alert('модерация закончена.');</script>";
        } else {
            echo 'ваш отзыв не записан в базу. попробуйте еще раз';
        }
        unset($_SESSION['q']);

    } else {
        echo "не подключились к базе";
    }
}

function get_count_reviews() {
    global $pdo;
    if ($pdo) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM `reviews` WHERE display=1");
        return $stmt->fetch();
    } else {
        echo "нет подключение к бд";
    }
}

function get_data_pagination($art, $show_count_reviews){
    global $pdo;
    if ($pdo) {
        $stmt = $pdo->query("SELECT * FROM `reviews` WHERE display=1 LIMIT $art, $show_count_reviews", PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    } else {
        echo "нет подключение к бд";
    }

}

function delete_review() {
    global $pdo;
    $item_review = $_SESSION['q'];
    $pdo->query("DELETE FROM `reviews` WHERE `reviews`.`id`=$item_review");
    unset($_SESSION['q']);
}

