<?php
session_start();
require("db.php"); // подключаемся к базе

// Устанавливаем временную зону
date_default_timezone_set('Europe/Moscow');
if (isset($_GET["remove"])) {
    // $_SESSION['cart'] = array_filter($_SESSION["cart"], function($el) {
    //     return $el !== $_GET["remove"];
    // });
    unset($_SESSION["cart"][$_GET["remove"]]);
}
// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["update_and_buy"])) {
        $action = $_POST["update_and_buy"];
 if ($action == 'buy') {
            foreach ($_POST['quantities'] as $id => $quantity) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$id] = $quantity;
                } else {
                    unset($_SESSION['cart'][$id]);
                }
            }
            // Формирование заказа
            $user_id = $_SESSION["user"]["id"];
            $order_date = date('Y-m-d H:i:s');
            $order_description = 'Order placed by user ID: ' . $user_id;

            try {
                // Начало транзакции
                $db->beginTransaction();

                // Создание нового заказа в таблице orders
                $stmt = $db->prepare("INSERT INTO orders (user_id, order_date, order_description) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $order_date, $order_description]);
                $order_id = $db->lastInsertId();

                // Добавление элементов заказа в таблицу order_info
                $stmt = $db->prepare("INSERT INTO order_info (order_id, item_id, quantity) VALUES (?, ?, ?)");
                foreach ($_SESSION['cart'] as $id => $quantity) {
                    $stmt->execute([$order_id, $id, $quantity]);
                }

                // Завершение транзакции
                $db->commit();

                // Очистка корзины
                unset($_SESSION["cart"]);

                echo "<script>alert('Вы успешно купили! Администратор обработает ваш заказ');
                location.href='index.php'</script>";
            } catch (Exception $e) {
                // В случае ошибки откат транзакции
                $db->rollBack();
                echo "Failed: " . $e->getMessage();
            }
        }
    }
}

// Получение товаров из корзины
$cart = [];
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $stmt = $db->prepare("SELECT * FROM items WHERE id=?");
        $stmt->execute([$id]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($info) {
            $info['quantity'] = $quantity;
            $cart[] = $info;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PartsZip</title>
    <link rel="stylesheet" href="indexStyle.css">
    <link rel="stylesheet" href="allStyle.css">
    <link rel="icon" href="images/logoicon.png">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
    <div id="app">
        <header>
            <div class="headerContainer">
                <a href="../Glavnaya/index.php" class="logo">
                    <p class="logoText">PartsZip</p>
                </a>
                <div class="buttonContainer" v-bind:class="{ visible: burger}" @click="burger= !burger, activeBurger= !activeBurger">
                    <button class="themChange buttonBorder " @click="map= !map"></button>
                    <a href="../Profile/index.php" class="userImg buttonBorder"></a>
                    <a href="../Profile/index.php" class="userImg buttonBorder mobileUserImg" @click="userInfo= !userInfo"></a>
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
                    <div class="mainInfoStart">Корзина</div>
                </div>
                <div class="line"></div>
                <div class="functionButtons">
                    <input class="surnameInput" placeholder="Поиск" type="text">
                    <div class="fButtonContainer">
                        <button class="filter buttonBorder">
                            <img class="filterImg" src="images/filterWhite.png" alt=""> Фильтры
                        </button>
                    </div>
                </div>
                <div class="opisContainer">
                    <p class="opis">Поставщик</p>
                    <p class="opis naimen">Наименование</p>
                    <p class="opis">Сумма</p>
                </div>
                <form action="korzina.php" method="POST">
                    <?php foreach ($cart as $item) { ?>
                    <div class="itemsContainer">
                        <div class="item">
                            <div class="groupImgPostTel">
                                <img class="postavImg" src="<?php echo $item["companyPhoto"] ?>" alt="картинка компании">
                                <div class="groupPostTel">
                                    <div class="post osnovText"><?php echo $item["companyName"] ?></div>
                                    <div class="tel"><?php echo $item["companyTelephone"] ?></div>
                                </div>
                            </div>
                            <div class="nameItem">
                                <img class="itemImg" src="<?php echo $item["photo"] ?>" alt="картинка компании">
                                <div class="nameItemText osnovText"><?php echo $item["name"] ?></div>
                            </div>
                            <div class="summa">
                                <?php echo $item["price"] ?> ₽
                                
                            </div>
                            <span class="kolvo spanKolvo"><input type="number" class="kolvo" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" max="10">шт.</span>
                            </form>

                            <form action="#">
                        <input type="hidden" name="remove" value="<?php echo key($_SESSION['cart']); next($_SESSION['cart']);  ?>">
                        <button class="btn noneButton">
                       <div class="buttonAddItem gradient">
                        <img src="images/deleteKorzin.png" alt="">
                        <div class="buttonAddText">Удалить из корзины</div>
                        </div>
                        </button>
                    </form>  
                        
                        </div>
                    </div>
                    <?php } ?>
                    <form action="korzina.php" method="POST">
                    <center>
                    <button  class="btn noneButton filter buttonBorder noneWidth" type="submit" name="update_and_buy" value="buy">Сформировать заказ</button>
                    </center>
                    </form>
                
            </div>
        </main>
    </div>
    <script src="main.js"></script>
</body>
</html>
