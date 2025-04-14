<?php /** @var \App\Models\Youtubechannel $youtubechannel */ ?>

<article class="mb-3">

    <h2>Channel: <strong>{{ $youtubechannel->name }}</strong></h2><h3> Рейтинг: {{ $youtubechannel->raiting }}</h3>
    <h4>Лайки: {{ $youtubechannel->totalLike }} Дизлайки: {{ $youtubechannel->totaldislikes }}</h4>

    <table class="table table-sm">
        @foreach ($youtubechannel->videos as $videos)
            <tr>
                <td><h5>Видео: {{$videos['title']}}</h5></td>
                <td><p>лайки: {{$videos['like']}}</p></td>
                <td><p>дизлайки: {{$videos['dislikes']}}</p></td>
                <td><p>url: {{$videos['videourl']}}</p></td>

            </tr>
        @endforeach
    </table>
</article>
