<?php
require("db.php"); // подключаемся к базе

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
    echo "<script>alert('Вам сюда нельзя!'); location.href='index.php'</script>";
}


if (!empty($_GET)) {
    if (isset($_GET["add"])) {
        $name = $_GET["name"];
        $photo = $_GET["photo"];
        $price = $_GET["price"];
        $companyName = $_GET["companyName"];
        $companyTelephone = $_GET["companyTelephone"];
        $companyPhoto = $_GET["companyPhoto"];

        if ($db->query("INSERT INTO items SET name='$name', photo='$photo', price=$price, companyName='$companyName',
         companyTelephone='$companyTelephone', companyPhoto='$companyPhoto' ")) {
            echo "<script>alert('Успешно добавлено!'); location.href='admin.php'</script>";
        } else {
            print_r($db->errorInfo());
            // echo "<script>alert('Товар не добавлен!'); location.href='admin.php'</script>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <link rel="stylesheet" href="allStyle.css">
    <link rel="stylesheet" href="forms.css">
</head>

<body>
    <div id="app">
        <div class="notmap" v-bind:class="{ map: map}" @click="map= !map">
            <div class="mapCon">
                <div class="mapClose">
                    <span class="mLine topMLine  active "></span>
                    <span class="mLine bottomMLine active "></span>
                </div>
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ad4db9309899ccd9099506749b4d58f5b4735cf26f216e8808582bb48bcd69c86&amp;source=constructor" width="600" height="500" frameborder="0"></iframe>
            </div>
        </div>
        <header>
            <div class="headerContainer">
                <a href="../Glavnaya/index.php" class="logo">
                    <p class="logoText">PartsZip</p>
                </a>

                <div class="buttonContainer" v-bind:class="{ visible: burger}" @click="burger= !burger, activeBurger= !activeBurger">
                    <button class="themChange  buttonBorder " @click="map= !map"></button>
                    <?php if (empty($_SESSION["user"])) : ?>


                        <a href="../Glavnaya/login.php" class="login"><img class="loginImg" src="images/login.png" alt="">
                            <p>Войти</p>
                        </a>
                    <?php else : ?>
                        <!-- <a href="../Profile/index.php" class="userImg buttonBorder"></a>
                  <a href="../Profile/index.php" class="userImg buttonBorder mobileUserImg" @click="userInfo= !userInfo"></a> -->
                        <a href="index.php?logout" class="login logoutImg"><img class="logoutImg" src="images/logout.png" alt="">
                            <p>Выйти</p>
                        </a>
                    <?php endif; ?>

                </div>
                <div class="menuBurgerHeader" @click="burger= !burger, activeBurger= !activeBurger">
                    <span class="burgerLine topLine " v-bind:class="{ active: activeBurger }"></span>
                    <span class="burgerLine centerLine " v-bind:class="{ active: activeBurger }"></span>
                    <span class="burgerLine bottomLine " v-bind:class="{ active: activeBurger }"></span>
                </div>
            </div>
        </header>
        <!-- <h1>Панель администратора</h1> -->
        <section>
            <center>
                <h2>Добавить товар</h2>
            </center>

            <div class="container">
                <form class="loginForm" action="#">
                    <div class="containerEmail">
                        <p class="email">Название</p>
                        <div class="emaileBig"> <input class=" writeEmail" type="text" name="name"></div>
                    </div>
                    <div class="containerEmail">
                        <p class="email"> Ссылка на фото</p>
                        <div class="emaileBig"> <input class=" writeEmail" type="text" name="photo"></div>
                    </div>
                    <div class="containerEmail">
                        <p class="email">Цена</p>
                        <div class="emaileBig"> <input class=" writeEmail" type="number" name="price"></div>
                    </div>
                    <div class="containerEmail">
                        <p class="email">Наименование поставщика</p>
                        <div class="emaileBig"> <input class=" writeEmail" type="text" name="companyName"></div>
                    </div>
                    <div class="containerEmail">
                        <p class="email">Телефон поставщика</p>
                        <div class="emaileBig"> <input class=" writeEmail" type="text" name="companyTelephone"></div>
                    </div>
                    <div class="containerEmail">
                        <p class="email">Логотип поставщика</p>
                        <div class="emaileBig"> <input class=" writeEmail" type="text" name="companyPhoto"></div>
                    </div>




                    <input type="hidden" name="add">
                    <button class="filter buttonBorder buttonReg">Добавить</button>

                </form>
            </div>
        </section>
    </div>
</body>

</html>