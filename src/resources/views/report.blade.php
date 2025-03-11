<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<p>Hello</p>
<ul>
    <?php /** @var \App\Domain\Entity\News $news */ ?>
    @foreach($newsList as $news)
        <li><a href="{{ $news->getUrl()->getUrl()  }}">{{ $news->getName()->getName() }}</a></li>
    @endforeach
</ul>
</body>
</html>
