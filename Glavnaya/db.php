<?php
// подключение базы данных
    $db = new PDO(
        "mysql:host=localhost;dbname=kursovay;charset=utf8", "root", ""
    );
    if(!isset($_SESSION))
    {
        session_start();
    }
?>