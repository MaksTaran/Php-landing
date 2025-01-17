<?php
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

$item ;

if(isset($_GET["item_id"])){
    $item = $_GET["item_id"];
}


$items = $db->query("SELECT * FROM items WHERE $item = id")->fetchAll(2);

if (isset($_GET['korzina'])) {



    $_SESSION['cart'][] = $_GET['item_id'];
    
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keldish</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
       <a href="index.php"> <img class="logo" src="img/logo.png" alt=""></a>
       <div class="nav">
        <a href="oNas.php">О нас</a>
        <a href="index.php">Каталог</a>
        <a href="where.php">Где нас найти?</a>
        <?php if (empty($_SESSION["user"])) : ?>
            <a href="login.php"><div class="buttonVxod">Войти</div></a>
            <a href="signup.php"><div class="buttonVxod buttonRgistr">Регистрация</div></a>
            <?php else : ?>
            <a href="index.php?logout"><div class="buttonVxod">Выйти</div></a>
            <a href="cart.php"><div class="buttonVxod buttonRgistr">Корзина</div></a>
            <?php endif; ?>
    </div>
    </header>
    <div class="container">
        <div class="containerCat">

      
        <h1>Товар</h1>
        <?php foreach ($items as $item) : ?>
        <div class="tovarDesc">
        <img class="itemImg" src="<?php echo $item["image"] ?>" alt="">
            <div class="tovarDescription">
                <p class="nameItem"><?php echo $item["name"] ?> </p>
                <p><?php echo $item["problema"] ?>₽</p>
                <div class="descriptionItem">
                   <h4> Основные характеристики</h4>
                   <?php echo $item["description"] ?>

                    <div class="marginTop">
                        <?php if (!empty($_SESSION["user"])) : ?>
                            <form action="">
                                <button name="korzina" class="korzina">В корзину</button>
                                <input name="item_id" type="text" hidden value="<?php echo $item['id'] ?>">
                            </form>
                        <?php endif; ?>
                   </div>
        </div>
                
                
            </div>
        
        </div>
    </div>
    <?php endforeach; ?>

        </div>

        <!-- Каждая страница содержит фото товара, наименование, цену и характеристики (страна- производитель, год выпуска,
        модель).
         -->
</body>
</html>