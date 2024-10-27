<?php
if (!empty($data['news'])) { ?>
    <div style="display: flex; flex-direction: column">
        <div style="display: flex">
            <span>Название: </span>
            <span><?= $data['news']['name'] ?></span>
        </div>
        <div style="display: flex">
            <span>Дата публикации: </span>
            <span><?= $data['news']['date_created'] ?></span>
        </div>
        <div style="display: flex">
            <span>Категория: </span>
            <span><?= $data['news']['category'] ?></span>
        </div>
        <div style="display: flex">
            <span>Автор: </span>
            <span><?= $data['news']['author'] ?></span>
        </div>
        <div style="display: flex">
            <span>Текст: </span>
            <span><?= $data['news']['text'] ?></span>
        </div>
    </div>


<?php
} else {
    ?>
<p style="color:red;">Новость не найдена</p>
<?php
}