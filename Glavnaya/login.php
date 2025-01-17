<?php

require "db.php";

if (!empty($_POST)) {

    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $result = $db->query("SELECT * FROM users WHERE email='$email' AND password='$password'")->fetchAll(2);

    if (count($result) > 0) {
        $_SESSION["user"] = $result[0];

        echo "<script>
            alert('Добро пожаловать!');
            location.href='index.php';
        </script>";
    } else {
        echo "<script>
            alert('Неверный логин или пароль!')
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="allStyle.css">
    <link rel="stylesheet" href="forms.css">
</head>

<body>
    <main>
        <form class="loginForm" action="#" method="post">
            <h1>Авторизация</h1>
            <div class="containerEmail">
                <p class="email">Логин</p>
                <div class="emaileBig"> <input class=" writeEmail" type="text" name="email"></div>
            </div>
            <div class="containerEmail">
                <p class="email">Пароль</p>
                <div class="emaileBig"> <input class=" writeEmail" type="text" name="password"></div>
            </div>


    

            <button class="filter buttonBorder marginTop">Войти</button>

            <p class="create_acc">
                Нет аккаунта? <a href="reg.php">Создать</a>
            </p>
            <p class="naGlav">
                <a href="index.php">Вернуться на главную</a>
            </p>
        </form>
    </main>
    <!-- <div class="preloader">
    <div class="loader"></div>
</div> 
<script src="main.js"></script>   -->
</body>

</html>