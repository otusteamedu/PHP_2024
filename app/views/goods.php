<?php
/** @var App\modules\User [] $goods */

foreach ($goods as $good) : ?>
 <div class="card product " style="width: 18rem;" >
     <a href="?c=good&a=one&id=<?= $good->id ?>"><img class="smallImg card-img-top" src="./img/<?= $good->img_dir ?>" alt=""></a>
     <div class="card-body">
         <h5 class="card-title"><?= $good->name_product ?></h5>
         <p class="card-text">Цена <?= $good->price_product ?>р</p>
         <a href="?c=good&a=deleteFromDB&id=<?= $good->id ?>"><button class="comeBackBtn">Удалить из базы</button></a>
     </div>
 </div>
<?php endforeach;?>


<html>
<div class="card product addProduct" style="width:18rem" >

        <div class="card bg-dark text-white">
            <img src="https://via.placeholder.com/300x250" class="card-img" alt="...">
            <div class="card-img-overlay">
                <h5 class="card-title">Загрузить картинку</h5>
                <form enctype="multipart/form-data"  method="POST" action="?c=good&a=addToDB">
                    <input name="userfile" type="file" />

            </div>
        </div>
        <div class="card-body">
            <input name="name_product" type ="text" class="form-control" placeholder="имя продукта" >
            <input name="price_product" type ="number" class="form-control"placeholder="цена" >
            <input name="description_short" type ="text" class="form-control"placeholder="описание" >
            <input class="comeBackBtn" type="submit" value="Добавить продукт">

        </div>
    </form>
</div>

</html>