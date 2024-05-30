<ul class="list-group">

<?php
/** @var App\modules\User [] $users */

foreach ($users as $user) : ?>
    <a href="?c=user&a=one&id=<?=$user->id ?>">
        <div class="card-body"><li class="list-group-item">

            <h5 class>
                  <?=  $user->login ?>
                <a href="?c=user&a=deleteFromDB&id=<?=$user->id ?>"><button class="comeBackBtn">Удалить</button></a>
            </h5>
            </li>
     </div>
    </a>
<?php endforeach;?>
    <a href="?с=user&a=addToDB"><div class="card-body"><li class="list-group-item">Добавить</li> </div></a>
</ul>
