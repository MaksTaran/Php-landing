<?php
session_start();
require("db.php"); // подключаемся к базе

if (!empty($_GET)) {
    if (isset($_GET["logout"])) {
        $_SESSION["user"] = [];
        echo "<script>
        alert('До свидания!');
        location.href='index.php';
        </script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_email'])) {
    $new_email = $_POST['new_email'];
    $user_id = $_SESSION['user']['id'];
    
    // Обновляем почту пользователя в базе данных
    $stmt = $db->prepare("UPDATE users SET email = :email WHERE id = :id");
    $stmt->bindParam(':email', $new_email);
    $stmt->bindParam(':id', $user_id);
    if ($stmt->execute()) {
        echo "<script>
        alert('Почта успешно обновлена!');
        location.href='personal.php';
        </script>";
    } else {
        echo "<script>
        alert('Ошибка при обновлении почты!');
        </script>";
    }
}

$user_id = $_SESSION['user']['id'];
$users = $db->query("SELECT * FROM users WHERE id = $user_id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PartsZip</title>
   

    <link rel="stylesheet" href="personalStyle.css">
    <link rel="stylesheet" href="allStyle.css">
    <link rel="icon" href="images/logoicon.png">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
    <div id="app">
        <div class="notmap" v-bind:class="{ map: map}" @click="map= !map">
            <div class="mapCon">
                <div class="mapClose">
                    <span class="mLine topMLine active"></span>
                    <span class="mLine bottomMLine active"></span>
                </div>
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ad4db9309899ccd9099506749b4d58f5b4735cf26f216e8808582bb48bcd69c86&amp;source=constructor" width="600" height="500" frameborder="0"></iframe>
            </div>
        </div>
        <header>
            <div class="headerContainer">
                <a href="../Glavnaya/index.php" class="logo">
                    <p class="logoText">PartsZip</p>
                </a>
                <?php foreach ($users as $user) : ?>
                    <div class="buttonContainer" v-bind:class="{ visible: burger}" @click="burger= !burger, activeBurger= !activeBurger">
                        <button class="themChange buttonBorder" @click="map= !map"></button>
                        <button class="userImg buttonBorder"><img class="userImgSmall" src="<?php echo $user["photo"] ?>" alt=""></button>
                        <button class="userImg buttonBorder mobileUserImg" @click="userInfo= !userInfo"></button>
                        <a href="../Glavnaya/index.php" class="close"></a>
                    </div>
                    <div class="menuBurgerHeader" @click="burger= !burger, activeBurger= !activeBurger">
                        <span class="burgerLine topLine" v-bind:class="{ active: activeBurger }"></span>
                        <span class="burgerLine centerLine" v-bind:class="{ active: activeBurger }"></span>
                        <span class="burgerLine bottomLine" v-bind:class="{ active: activeBurger }"></span>
                    </div>
            </div>
        </header>

        <main>
            <div class="mainContainer">
                <div class="leftSection" v-bind:class="{showUserInfo: userInfo}">
                    <div class="userInfoContainer">
                        <div class="fonUser"></div>
                        <div class="userInfo">
                            <img src="<?php echo $user["photo"] ?>" class="userImgMain" alt="">
                            <p class="userName"><?php echo $user["surname"] ?> <?php echo $user["name"] ?> </p>
                            <p class="status">Пользователь</p>
                        </div>
                    </div>
                    <div class="infoList">
                        <div class="infoBlockList">
                            <div class="number li"><?php echo $user["telephone"] ?></div>
                            <div class="mail li"><?php echo $user["email"] ?></div>
                            <div class="date li"><?php echo $user["birthDay"] ?></div>
                            <div class="serviceCenter li">
                                <p class="serviceText">RemBrand</p>
                                <p class="serviceTextText">Сервисный центр</p>
                            </div>
                            <div class="exitMain">
                                <div class="exitMainFoto"><img src="images/exitMain.png" class="exitMainImg" alt=""></div>
                                <div class="exitText">Выйти из аккаунта</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mainIndex">
                    <div class="mainIndexContainer fixMainIndex">
                        <div class="mainHad">
                            <a href="index.php">
                                <div class="mainHadText">Персональная информация</div>
                            </a>
                            <a href="personal.php">
                                <div class="mainHadText personalInfoHad">Учетная запись</div>
                            </a>
                        </div>
                        <div class="containerInfo fixCon">
                            <form action="#" method="post">
                                <div class="mainInfo">
                                    <div class="mainInfoStart">Редактировать информацию</div>
                                    <div class="containerEmail">
                                        <p class="email">E-mail</p>
                                        <div class="emaileBig">
                                            <img class="marker proofMarkerMobile" src="images/proof.png" alt="">
                                            <p class="emaileBig"><?php echo $user["email"] ?></p>
                                            <img class="marker" src="images/marker.png" alt="">
                                        </div>
                                    </div>
                                    <div class="containerEmail">
                                        <p class="email">Введите новую почту</p>
                                        <div class="emaileBig">
                                            <input class="writeEmail" type="text" name="new_email" required>
                                        </div>
                                    </div>
                                    <div class="containerEmail">
                                        <p class="proof email">На Ваш номер телефона <span class="proof shifr">****38-09</span> придет СМС с <span class="proof shifr">кодом для подтверждения</span> изменения электронной почты</p>
                                    </div>
                                </div>
                                <div class="containerButton">
                                    <button type="submit" class="changesCod">Получить код</button>
                                    <button type="button" class="notChangesCod">Отменить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="preloader">
            <div class="loader"></div>
        </div>
    </div>
    <?php endforeach; ?>
    <script src="main.js"></script>
</body>
</html>
