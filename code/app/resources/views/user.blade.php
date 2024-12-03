<html>
    <head>
        <title>
            Список сотрудников API
        </title>
    </head>
    <body>
        <h1>{{$user["full_name"]}}</h1>
        <div>
            <img src="{{$user["photo"]}}" width="300px" height="300px">
        </div>
        </br>

        <div style="background:#FF6600">
        @foreach (['full_name', 'email', 'direction', 'post'] as $key)
                <label style="color:#FFFFFF">
                    {{$user[$key]}}
                </label>
                </br>
        @endforeach
        </div>

        <form action="/">
            <input type="submit" value="К списку" />
        </form>
    </body>
</html>
