<?php
class YouTubeVideo
{
    /**
     * ID канала
     * @var string
     */
    public string $channelId;

    /**
     * ID видео
     * @var string
     */
    public string $videoId;

    /**
     * Количество лайков
     * @var int
     */
    public int $likes;

    /**
     * Количество дизлайков
     * @var int
     */
    public int $dislikes;

    /**
     * Конструктор для создания объекта видео.
     *
     * @param string $channelId
     * @param string $videoId
     * @param int $likes
     * @param int $dislikes
     */
    public function __construct(string $channelId, string $videoId, int $likes, int $dislikes)
    {
        $this->channelId = $channelId;
        $this->videoId = $videoId;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
    }
    public function toArrayForElastic(): array
    {
        return [
            'chanelId' => $this->channelId,
            'videoId' => $this->videoId,
            'like' => $this->likes,
            'notlike' => $this->dislikes,
        ];
    }
}
