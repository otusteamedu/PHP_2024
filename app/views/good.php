

    <div class="card mb-3 text-center" style="width:50rem" >
        <div class="row no-gutters">
            <div class="col-md-6">
                <img  class="card-img" src="img/<?= $good->img_dir?>">
            </div>
            <div class="col-md-6">
                 <div class="card-body">
                     <!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
                     <form enctype="multipart/form-data" action="?c=good&a=addToDB&id=<?= $good->id ?>" method="POST">
                            <h6 >Обновить Картинку</h6>
                            <input name="userfile" type="file" ><br><br>
                            <input name="name_product" type ="text" class="form-control" value="<?= $good->name_product ?> ">
                            <input name="price_product" type ="number" class="form-control"value="<?= $good->price_product ?>" >
                            <input name="description_short" type ="text" class="form-control" value="<?= $good->description_short ?> ">
                            <input type="submit" class="comeBackBtn" value="Изменить продукт" >
                     </form>

                 </div>
            </div>
        </div>
        <a href="?c=good"><button class="comeBackBtn">К Каталогу</button></a>
    </div>

