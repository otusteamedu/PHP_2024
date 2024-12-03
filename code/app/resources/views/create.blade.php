<html>
<head>
    <title>
        Опишите сотрудника
    </title>
</head>
<body>
    <form action="/create" method="POST">
        <label>ID</label><input type="text" name="ID" required> </br>

        <label>Name: </label>
        <input type="text" name="full_name" required> <!-- Жмышенко Михаил Зубенкович -->
        </br>

        <label>email: </label>
        <input type="email" id="email" name="email" required> <!-- jmish@email.net -->
        </br>

        <label>photo link</label>
        <input type="text" name="photo" required> <!-- https://i.ytimg.com/vi/UGEntLi6ewY/maxresdefault.jpg -->
        </br>

        <input type="submit">
    </form>

    <form action="/">
        <input type="submit" value="К списку" />
    </form>

</body>
</html>
