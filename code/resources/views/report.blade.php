<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <ul>
        @foreach ($newsList as $news)
        <li>
            <a href="{{$news->getUrl()->getValue()}}">{{$news->getTitle()->getValue()}}</a>
        </li>
        @endforeach
    </ul>
</body>

</html>