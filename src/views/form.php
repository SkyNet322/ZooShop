<?php
/** @var string $type */
/** @var string $error */
?>

    <div style="width: 620px;margin: 0 auto;">
        <div style="text-align: center;">
            <a href="/" style="text-decoration: none;color: red;font-weight: 700;text-transform: uppercase;padding: 10px;">Главная</a>
            <a href="/search" style="text-decoration: none;color: blue;font-weight: 700;text-transform: uppercase;padding: 10px;">Поиск</a>
        </div>
        <?php if (isset($error)) : ?>
            <?= "<div>$error</div>"; ?>
            <?= "<button onclick=\"window.location.href='/'\">Click in me</button>" ?>
        <?php endif; ?>
        <?php if ($type == 'create') : ?>
        <h2 style="text-align: center;">Добавить товар</h2>
        <?php elseif ($type == 'search') : ?>
        <h2 style="text-align: center;">Найти товар</h2>
        <?php endif; ?>
        <?php if ($type == 'create') : ?>
            <form method="POST" action="/create" style="width: 100%;margin: 0 auto;">
        <?php elseif ($type == 'search') : ?>
            <form method="POST" action="/search" style="width: 100%;margin: 0 auto;">
        <?php endif; ?>
                <div style="margin: 0 auto;">
                <div style="float: left;padding-right: 15px;text-align: center;">
                    <p>Название:<br>
                        <input type="text" name="name"></p></div>
                <div style="float: left;padding-right: 15px;text-align: center;">
                    <p>Животные: <br>
                        <input type="radio" name="category" value="animal"></p>
                    <p>Корм: <br>
                        <input type="radio" name="category" value="food"></p>
                    <p>Сопутсвтующие товары: <br>
                        <input type="radio" name="category" value="product"></p>
                </div>
                <div style="float: left;text-align: center;">
                    <p>Для кошек: <br>
                        <input type="checkbox" name="cat" value="1"></p>
                    <p>Для собак: <br>
                        <input type="checkbox" name="dog" value="1"></p>
                    <p>Для рыб: <br>
                        <input type="checkbox" name="fish" value="1"></p>
                    <p>Для амфибий: <br>
                        <input type="checkbox" name="amphibia" value="1"></p>
                    <p>Для грызунов: <br>
                        <input type="checkbox" name="rodent" value="1"></p>
                    <p>Для рептилий: <br>
                        <input type="checkbox" name="reptile" value="1"></p></div>

                <div style="clear: both;text-align: right;padding-right: 16px;">
        <?php if ($type == 'create') : ?>
                    <input type="submit" value="Добавить" style="background-color: #8e8eff;border-radius: 30px; padding: 5px 20px;">
        <?php elseif ($type == 'search') : ?>
                    <input type="submit" value="Поиск" style="background-color: #8e8eff;border-radius: 30px; padding: 5px 20px;">
        <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
