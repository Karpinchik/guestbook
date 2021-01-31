<?php
require_once "functions/function.php";

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
} else $page = 1;

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $show_count_reviews = 5;
    $art = ($page * $show_count_reviews) - $show_count_reviews;

    $all_reviews = get_count_reviews();
    $res_pagination = get_data_pagination($art, $show_count_reviews);
    $str_pag = ceil($all_reviews[0] / $show_count_reviews);

    for ($i = 1; $i <= $str_pag; $i++){
        $pagin_link .= "<a href=index.php?page=".$i.">  ".$i." </a>";
    }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['title-review']) && !empty($_POST['message-review']) && !empty($_POST['name-review'])
        && !empty($_POST['phone-review']) && !empty($_POST['email-review']))
    {
        set_reviews();
        echo "<script>window.location.replace('index.php');</script>";
    } else {
        echo "<script>alert('необходимо заполнить все поля формы.');</script>";
        echo "<script>window.location.replace('index.php');</script>";
    }
}

require_once "./review.html";




