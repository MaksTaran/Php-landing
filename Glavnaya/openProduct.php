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

$item;

if (isset($_GET["item_id"])) {
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="openProduct.css">
    <title>Document</title>
</head>

<body>

    <?php foreach ($items as $item) : ?>
        <div class="containerOil">

            <img class="leftImg" src="<?php echo $item["photo"] ?>" alt="">
            <a class="closeTov" href="index.php">X</a>
            <div class="conContainerOil">

                <div class="infoOil">
                    <div class="zaglavtext">
                        <p><?php echo $item["name"] ?></p>
                    </div>
                </div>
                <div class="infoOil">
                    <div class=" description">
                        <p><?php echo $item["description"] ?></p>
                    </div>
                </div>
                <div class="prices">
                    <div class="priceOil"><?php echo $item["price"] ?> руб./шт</div>
                </div>
                <?php if (!empty($_SESSION["user"])) : ?>
                    <form action="">
                        <div class="buttonAddItem">
                            <button class="buttonAddText noneButton" name="korzina" class="korzina">
                                <img loading="lazy" src="images/addKorzin.png" alt="">
                                Добавить в корзину</button>
                        </div>
                        <input name="item_id" type="text" hidden value="<?php echo $item['id'] ?>">
                    </form>
                <?php endif; ?>
                <?php if (empty($_SESSION["user"])) : ?>
                    <form action="">
                        <div style="opacity: 0; cursor:default;" class="buttonAddItem">
                            <div style="opacity: 0; cursor:default;" class="buttonAddText noneButton" name="korzina" class="korzina">
                                <img loading="lazy" src="images/addKorzin.png" alt="">
                                Добавить в корзину
                            </div>
                        </div>
                        <input name="item_id" type="text" hidden value="<?php echo $item['id'] ?>">
                    </form>
                <?php endif; ?>
                <div class="uslCeni">Цена действительна только для интернет-магазина и может отличаться от цен в розничных магазинах</div>
            </div>

        </div>
    <?php endforeach; ?>

    <div class="v329_289"><span class="v329_290">Cинтетическое моторное масло передового уровня свойств
            для легковых автомобилей</span></div><span class="v329_291">Подробнее </span>
    </div>
    <span class="v329_296">4 949 руб./шт</span>

    <span class="v329_360">Цена действительна только для интернет-магазина и может отличаться от цен в
        розничных магазинах</span> -->
</body>

</html>