<?php

/** @var array $data */
/** @var array $headers */
//var_dump($data);

?>

<?php if ($data) : ?>
    <div style="text-align: center;">
        <a href="/" style="text-decoration: none;color: red;font-weight: 700;text-transform: uppercase;padding: 10px;">Главная</a>
        <a href="/search" style="text-decoration: none;color: blue;font-weight: 700;text-transform: uppercase;padding: 10px;">Поиск</a>
    </div>

    <table border="1" style="margin: 0 auto;text-align: center;">
        <thead>
            <tr>
                <?php foreach ($headers as $header) : ?>
                    <?= "<th>$header</th>" ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($data as $row) : ?>
            <tr>
                <?php foreach ($row as $value) : ?>
                    <?= "<td>$value</td>" ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <div>Нет данных</div>
<?php endif; ?>

<style>
    th {
        padding-left: 10px;
        padding-right: 10px;
    }
    td {
        padding: 10px;
    }
</style>
