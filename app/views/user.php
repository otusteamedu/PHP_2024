<div>
    <h1> <?=$user->login ?></h1>
    <h2> <?=$user->name ?></h2>
    <a href="?c=user&a=addToDB&id=<?=$user->id ?>"><button class="comeBackBtn">Обновить</button></a>
    <a href="?c=user&a=deleteFromDB&id=<?=$user->id ?>"><button class="comeBackBtn">Удалить</button></a>
</div>


