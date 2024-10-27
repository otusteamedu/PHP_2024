<?php

if (!empty($data['data']['news_list'])) {
    foreach ($data['data']['news_list'] AS $news) {
    ?>
    <div style="display: flex; flex-direction: column; margin: 5px; border: 1px solid black">
        <div style="display: flex">
            <span>Название: </span>
            <span><?= $news['name'] ?></span>
        </div>
        <div style="display: flex">
            <span>Дата публикации: </span>
            <span><?= $news['date_created'] ?></span>
        </div>
        <div style="display: flex">
            <span>Категория: </span>
            <span><?= $news['category'] ?></span>
        </div>
        <div style="display: flex">
            <span>Автор: </span>
            <span><?= $news['author'] ?></span>
        </div>
        <div style="display: flex">
            <span>Текст: </span>
            <span><?= $news['text'] ?></span>
        </div>
        <div style="display: flex">
            <span></span>
            <a href="/news/by/id?id=<?= $news['id'] ?>">Ссылка</a>
        </div>
    </div>
    <?php
    }
} else {
    ?>
    <p style="color:red;">Новости не найдены</p>
    <?php
}