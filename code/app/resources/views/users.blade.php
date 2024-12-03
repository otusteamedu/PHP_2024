<html>
    <head>
        <title>
            Список сотрудников API
        </title>
    </head>
    <body>
        <h1>Список сотрудников</h1>

        <form action="/create">
            <input type="submit" value="Создать сотрудника" />
        </form>

        @foreach ($users as $user)
            <div style="background:#FF6600">
                <div>
                    <img src="{{$user["photo"]}}" width="300px" height="300px">
                </div>
                <div style="color:#FFFFFF">
                    <p>{{$user["full_name"]}}</p>
                    <!--
                    <p> Должность: {{$user["post"]}}</p>
                    <p> Дирекция:{{$user["direction"]}} </p>
                    -->
                </div>

                <form action="/u/{{$user['id']}}">
                    <input type="submit" value="Подробнее" />
                </form>

            </div>
        @endforeach
    </body>
</html>
