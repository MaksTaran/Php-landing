<?php
// АКАУНТЫ:
// user@user.ru
// user
// admin@admin.ru
// admin
session_start();
require("db.php"); // подключаемся к базе

if (!empty($_GET)) {
    if (isset($_GET["logout"])) {
        $_SESSION["user"] = [];
        $_SESSION['cart'] = [];
        echo "<script>
        alert('До свидания!');
        location.href='index.php';
        </script>";
    }
}

$items = $db->query("SELECT * FROM items")->fetchAll(PDO::FETCH_ASSOC);



if (!empty($_POST)) {
    if (isset($_POST['korzina']) && isset($_POST['item_id'])) {
        $item_id = $_POST['item_id'];
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id] += 1; // Увеличиваем количество, если товар уже в корзине
        } else {
            $_SESSION['cart'][$item_id] = 1; // Добавляем новый товар в корзину
        }
    }
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    if ($db->query("DELETE FROM items WHERE id=$id")) {
        echo "<script>alert('Успешно удалено!'); location.href='index.php'</script>";
    } else {
        print_r($db->errorInfo());
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Качественные запчасти для телефона. Быстрое обслуживание, доступные цены. Заходите на наш сайт!">
    <meta name="keywords" content="запчасти для телефона, ремонт смартфонов, ремонт сотовых,
    магазин запчастей для телефонов, лучшие процессоры для смартфонов,
    адрес магазина запчастей телефонов, экран смартфона, iphone,
    сервис телефонов,    сломанный телефон,ремонт телефонов адреса,ремонт смартфонов,номер телефона ремонта телефонов,
    моба запчасти таля сотовых,сотов ремонт телефонов,ремонт сотовых,ремонт сотовых телефонов,ремонт телефонов москва,сервис телефонов">
    <title>PartsZip</title>
    <link rel="stylesheet" href="indexStyle.css">
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

                <div class="buttonContainer" v-bind:class="{ visible: burger}" @click="burger= !burger, activeBurger= !activeBurger">
                    <button class="themChange buttonBorder" @click="map= !map"></button>
                    <?php if (empty($_SESSION["user"])) : ?>
                        <a href="../Glavnaya/login.php" class="login"><img class="loginImg" src="images/login.png" alt="">
                            <p>Войти</p>
                        </a>
                    <?php else : ?>
                        <a href="../Profile/index.php" class="userImg buttonBorder"><img class="userImgSmall" src="images/persona2.jpg" alt=""></a>
                        <a href="../Profile/index.php" class="userImg buttonBorder mobileUserImg" @click="userInfo= !userInfo"><img class="userImgSmall" src="images/persona2.jpg" alt=""></a>
                        <a href="index.php?logout" class="login logoutImg"><img class="logoutImg" src="images/logout.png" loading="lazy" alt="">
                            <p>Выйти</p>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="menuBurgerHeader" @click="burger= !burger, activeBurger= !activeBurger">
                    <span class="burgerLine topLine" v-bind:class="{ active: activeBurger }"></span>
                    <span class="burgerLine centerLine" v-bind:class="{ active: activeBurger }"></span>
                    <span class="burgerLine bottomLine" v-bind:class="{ active: activeBurger }"></span>
                </div>
            </div>
        </header>
        <main>
            <div class="mainIndex">
                <div class="containerInfoStart">
                    <div class="mainInfoStart">iPhone 7 дисплей </div>
                    <p class="zaglavMal">144 предложений в Москве</p>
                </div>
                <div class="viborButtonContainer">
                    <div class="viborButton">
                        <div class="c1"></div> iPhone 7 акб
                    </div>
                    <div class="viborButton">
                        <div class="c2"></div> iPhone 7 дисплей оригинал
                    </div>
                    <div class="viborButton">
                        <div class="c3"></div> iPhone 7 шлейф камеры
                    </div>
                    <div class="viborButton">
                        <div class="c4"></div> iPhone 7 камера оригинал
                    </div>
                    <div class="viborButton">
                        <div class="c5"></div> iPhone 7 вибромотор
                    </div>
                </div>
                <div class="line"></div>
                <div class="functionButtons">
                    <input class="surnameInput" placeholder="Поиск" type="text">
                    <div class="fButtonContainer">
                        <?php if (!empty($_SESSION["user"]) && $_SESSION["user"]["role"] == "admin") : ?>
                            <a href="admin.php">
                                <button class="filter buttonBorder marginRight">
                                    Добавить товар
                                </button>
                            </a>
                        <?php endif; ?>
                        <button class="filter buttonBorder"><img class="filterImg" src="images/filterWhite.png" loading="lazy" alt=""> Фильтры</button>
                        <?php if (!empty($_SESSION["user"])) : ?>
                            <a href="korzina.php" class="korzina"><img class="korzinaImg" loading="lazy" src="images/korzina.png" alt=""> Корзина</a>
                        <?php endif ?>

                    </div>
                </div>
                <div class="opisContainer">
                    <p class="opis">Поставщик</p>
                    <p class="opis naimen">Наименование</p>
                    <p class="opis">Цена</p>
                </div>
                <?php foreach ($items as $item) : ?>
                    <div class="itemsContainer">
                        <a href="openProduct.php?item_id=<?= $item['id'] ?>">
                            <div class="item">
                                <div class="groupImgPostTel">
                                    <img class="postavImg" src="<?= $item["companyPhoto"] ?>" alt="картинка компании">
                                    <div class="groupPostTel">
                                        <div class="post osnovText"><?= $item["companyName"] ?></div>
                                        <div class="tel"><?= $item["companyTelephone"] ?></div>
                                    </div>
                                </div>
                                <div class="nameItem">
                                    <img class="itemImg" src="<?= $item["photo"] ?>" alt="картинка компании">
                                    <div class="nameItemText osnovText"><?= $item["name"] ?></div>
                                </div>
                                <div class="summa">
                                    <?= $item["price"] ?> ₽
                                </div>
                                <?php if (!empty($_SESSION["user"])) : ?>
                                    <form method="POST" action="">
                                        <div class="buttonAddItem">
                                            <button class="buttonAddText noneButton" name="korzina" class="korzina">
                                                <img loading="lazy" src="images/addKorzin.png" alt="">
                                                Добавить в корзину
                                            </button>
                                        </div>
                                        <input name="item_id" type="hidden" value="<?= $item['id'] ?>">
                                    </form>
                                <?php endif; ?>
                                <?php if (empty($_SESSION["user"])) : ?>
                                    <div style="opacity: 0; cursor: default;" class="buttonAddItem">
                                        <div style="opacity: 0; cursor: default;" class="buttonAddText noneButton">
                                            <img loading="lazy" src="images/addKorzin.png" alt="">
                                            Добавить в корзину
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($_SESSION["user"]) && $_SESSION["user"]["role"] == "admin") : ?>
                                    <div style="background-color: red;" class="cardButton"><a href="?delete=<?= $item['id']; ?>">Удалить</a></div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <footer>
            <div class="footer-container">
                <a href="../Glavnaya/index.php" class="logo">
                    <p class="logoText">PartsZip</p>
                </a>
                <div class="footer-section">
                    <h4>О нас</h4>
                    <p>Мы предлагаем широкий ассортимент запчастей для телефонов от ведущих производителей. <br> Качество и надежность — наш приоритет.</p>
                </div>
                <div class="footer-section">
                    <h4>Контакты</h4>
                    <p>Email: support@partsstore.com</p>
                    <p>Телефон: +7 (123) 456-78-90</p>
                    <p>Адрес: ул. Примерная, 123, Москва, Россия</p>
                </div>
                <div class="footer-section media-section">
                    <h4>Подпишитесь на нас</h4>
                    <div class="social-media">
                        <a href="https://vk.com" target="_blank"><img src="images/vk.png" alt="VK" loading="lazy"></a>
                        <a href="https://web.whatsapp.com/" target="_blank"><img src="images/whatsapp.png" alt="whatsapp" loading="lazy"></a>
                        <a href="https://web.telegram.org/a/" target="_blank"><img src="images/telegram.png" alt="telegram" loading="lazy"></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 PartsZip</p>
            </div>
        </footer>
        <div class="preloader">
            <div class="loader"></div>
        </div>
        <script src="main.js" async></script>
    </div>
</body>

</html>