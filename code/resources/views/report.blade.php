<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <ul>
        @foreach ($itemList as $item)
        <li>
            <a href="{{$item->url}}">{{$item->title}}</a>
        </li>
        @endforeach
    </ul>
</body>

</html>
