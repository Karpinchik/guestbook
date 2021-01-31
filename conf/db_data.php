<?php
session_start();

$dsn = 'mysql:host=localhost; dbname=guestbook;';
$user = 'root';
$password = '';
$pdo = new PDO($dsn, $user, $password);
