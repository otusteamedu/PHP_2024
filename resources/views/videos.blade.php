<!DOCTYPE html>
<html lang="{{str_replace('_','-',app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Все видео</title>
</head>
<body class="antialiased">
<div class="relative flex item-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <table class="table">
        <caption>Все видео</caption>
        <tr>
            <th>Название</th>
            <th>Лайки</th>
            <th>Дизлайки</th>
            <th>Канал</th>
        </tr>
        @foreach($videos as $video)
            <tr>
                <td>{{$video->name}}</td>
                <td>{{$video->likes}}</td>
                <td>{{$video->dislikes}}</td>
                <td>{{$video->channel_id}}</td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
