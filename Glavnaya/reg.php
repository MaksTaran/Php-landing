
<?php
require "db.php";

if (!empty($_POST)) {

    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];
    $birthDay = $_POST["birthDay"];
    $photo = $_POST["photo"];
    $password = md5($_POST["password"]);

    if ($db->query("INSERT INTO users (name,surname,telephone,birthDay,photo,email,password) VALUES ('$name','$surname','$telephone','$birthDay','$photo','$email','$password')")) {
        echo "<script>
                alert('Вы успешно зарегистрированы');
                location.href='login.php';
              </script>";
    } else {
        print_r($db->errorInfo());
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
            <h1>Регистрация</h1>
            <div class="containerEmail">
                <p class="email">Имя</p>
                <div class="emaileBig"> <input class=" writeEmail" required type="text" name="name"></div>
            </div>
            <div class="containerEmail">
                <p class="email">Фамилия</p>
                <div class="emaileBig"> <input class=" writeEmail" required type="text" name="surname"></div>
            </div>
            <div class="containerEmail">
                <p class="email">Телефон</p>
                <div class="emaileBig"> <input class=" writeEmail" type="tel" name="telephone"></div>
            </div>
            <div class="containerEmail">
                <p class="email">Почта</p>
                <div class="emaileBig"> <input class=" writeEmail" required type="email" name="email"></div>
            </div>
            <div class="containerEmail">
                <p class="email">День рождения</p>
                <div class="emaileBig"> <input class=" writeEmail" required type="date" name="birthDay"></div>
            </div>
            <div class="containerEmail">
                <p class="email">Ваше фото</p>
                <div class="emaileBig"> <input class=" writeEmail" required type="text" name="photo"></div>
            </div>
            <div class="containerEmail">
                <p class="email">Пароль</p>
                <div class="emaileBig"> <input class=" writeEmail" required type="password" name="password"></div>
            </div>
            <div class="containerEmail">
                <p class="email">Повторите пароль</p>
                <div class="emaileBig"> <input class=" writeEmail" required type="password" name="password_repeat"></div>
            </div>
        
            <div class="containerEmail displayFlex">
                <input class="custom-checkbox" id="happy" type="checkbox" name="rules">
                <label for="happy">Согласие с правилами регистрации</label>
                
            </div>
            
            <button class="filter buttonBorder buttonReg">Зарегестрироваться</button>
    
            <p class="create_acc">
                Есть аккаунт? <a href="login.php">Войти</a>
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
