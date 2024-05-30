

<form action="?c=user&a=addToDB&id=<?=$user->id ?>" method="post">
<label for="name">Имя</label><input class="form-control" type="text" name="name"  value="<?=$user->name ?>">
<label for="login">login</label><input class="form-control" type="text" name="login" value="<?=$user->login ?>">
<label for="password">Пароль</label><input class="form-control" type="text" name="password" value="">
    <input class="form-control" type="submit" value="обновить">
</form>