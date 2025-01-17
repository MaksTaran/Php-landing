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

$user_id = $_SESSION['user']['id'];
$users = $db->query("SELECT * FROM users WHERE id = $user_id")->fetchAll(PDO::FETCH_ASSOC);

// Обработка обновления информации пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthDay = $_POST['birthDay'];

    $stmt = $db->prepare("UPDATE users SET name = ?, surname = ?, birthDay = ? WHERE id = ?");
    $stmt->execute([$name, $surname, $birthDay, $user_id]);

    echo "<script>
    alert('Информация обновлена успешно!');
    location.href='index.php';
    </script>";
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
    <link rel="icon"  href="images/logoicon.png">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
    <div id="app">
    <div class="notmap" v-bind:class="{ map: map}" @click="map= !map">
        <div class="mapCon">
        <div class="mapClose"  >
        <span class="mLine topMLine  active "></span>
                <span class="mLine bottomMLine active "></span>
        </div>
            <iframe  src="https://yandex.ru/map-widget/v1/?um=constructor%3Ad4db9309899ccd9099506749b4d58f5b4735cf26f216e8808582bb48bcd69c86&amp;source=constructor" width="600" height="500" frameborder="0"></iframe>
        </div>
    </div>
            <header>
      <div class="headerContainer">
        <a href="../Glavnaya/index.php" class="logo">
            <p class="logoText">PartsZip</p>
        </a>
        <?php foreach ($users as $user) : ?>
            <div class="buttonContainer" v-bind:class="{ visible: burger}" @click="burger= !burger, activeBurger= !activeBurger">
                <button class="themChange  buttonBorder " @click="map= !map"></button>
                    <button class="userImg buttonBorder"><img class="userImgSmall" src="<?php echo $user["photo"] ?>" alt=""></button>
                    <button class="userImg buttonBorder mobileUserImg" @click="userInfo= !userInfo"></button>
                    <?php if (empty($_SESSION["user"])) : ?>
                  <a href="../Glavnaya/login.php" class="login" ><img class="loginImg" src="images/login.png" alt=""><p>Войти</p></a>
                  <?php else : ?>
                  <a href="../Glavnaya/index.php?logout" class="login logoutImg" ><img class="logoutImg" src="images/logout.png" alt=""><p>Выйти</p></a>
                  <?php endif; ?>
            </div>
            <div class="menuBurgerHeader"  @click="burger= !burger, activeBurger= !activeBurger">
                <span class="burgerLine topLine " v-bind:class="{ active: activeBurger }"></span>
                <span class="burgerLine centerLine " v-bind:class="{ active: activeBurger }"></span>
                <span class="burgerLine bottomLine " v-bind:class="{ active: activeBurger }"></span>
            </div>
      </div>
  </header>
  <main>

      <div class="mainContainer"> 
        <div class="leftSection" v-bind:class="{showUserInfo: userInfo}">
            <div class="userInfoContainer">
            <div class="fonUser">
            </div>
                <div class="userInfo">
                    <img src="<?php echo $user["photo"] ?>" class="userImgMain" alt="">
                    <p class="userName"><?php echo $user["surname"] ?> <?php echo $user["name"] ?> </p>
                    <p class="status">Пользователь</p>
                </div>
            </div>
            <div class="infoList">
                <div class="infoBlockList">
                    <div class="number li"><?php echo $user["telephone"] ?> </div>
                    <div class="mail li">  <?php echo $user["email"] ?></div>
                    <div class="date li"><?php echo $user["birthDay"] ?>    </div>
                
                    <div class="exitMain"><div class="exitMainFoto"><img src="images/exitMain.png" class="exitMainImg" alt=""></div>
                    <div class="exitText">Выйти из аккаунта</div></div>
                </div>
                
            </div>
        </div>
    <div class="mainIndex ">
        <div class="mainIndexContainer fixMainIndex">
            <div class="mainHad">
                <a href="index.php">
                <div class="mainHadText personalInfoHad"> 
                    Персональная информация
                </div>
            </a>
            <a href="personal.php">
                <div class="mainHadText "> 
                    Учетная запись
                </div>
                </a>
                
            </div>
            <div class="containerInfo fixCon">
                    <div class="mainInfo">
                            <div class="mainInfoStart">Редактировать информацию </div>
                            <form method="POST" action="">
                                <div class="containerSurname">
                                   <p class="surname">Фамилия</p> 
                                  <div class="surnameBig"> <input class="surnameInput" name="surname" value="<?php echo $user["surname"] ?>" type="text"></div>
                                </div>
                                <div class="containerSurname">
                                    <p class="surname">Имя</p> 
                                   <div class="surnameBig"> <input class="surnameInput" name="name" value="<?php echo $user["name"] ?>" type="text"> </div>
                                 </div>
                                 <div class="containerSurname">
                                    <p class="datarojdenia surname">Дата рождения</p> 
                                   <div class="surnameBig rojd"><input class="surnameInput" name="birthDay" value="<?php echo $user["birthDay"] ?>" type="text"></div>
                                 </div>
                                 <button class="changesButton" type="submit">Сохранить изменения</button>
                            </form>
                    </div>
            </div>
        </div>
    </div>
      </div>
      <div class="preloader">
        <div class="loader"></div>
      </div> 
  </main> 
</div>
<?php endforeach; ?>
  <script src="main.js"></script>  
</body>
</php>
