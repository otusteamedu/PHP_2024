<?php

namespace App\Services\RowDataGateway;

use PDO;
use PDOStatement;

class VideosRow
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var int|null
     */
    private ?int $channelsId = null;

    /**
     * @var string|null
     */
    private ?string $name = null;

    /**
     * @var int|null
     */
    private ?int $likes = 0;

    /**
     * @var int|null
     */
    private ?int $dislikes = 0;

    /**
     * @var PDO
     */
    private PDO $PDO;

    /**
     * @var PDOStatement
     */
    private PDOStatement $insertStatement;

    /**
     * @var PDOStatement
     */
    private PDOStatement $updateStatement;

    /**
     * @var PDOStatement
     */
    private PDOStatement $deleteStatement;

    /**
     * @param PDO $PDO
     */
    public function __construct(PDO $PDO)
    {
        $this->PDO = $PDO;
        $this->insertStatement = $PDO->prepare(
            'INSERT INTO videos (channel_id, name, likes, dislikes) VALUES (?, ?, ?, ?)'
        );
        $this->updateStatement = $PDO->prepare(
            'UPDATE videos SET channel_id = ( case when :ChannelsId is not null then :ChannelsId else channel_id end), name = ( case when :Name is not null then :Name else name end), likes = likes + :Likes, dislikes = dislikes + :Dislikes WHERE id = :Id'
        );
        $this->deleteStatement = $PDO->prepare(
            'DELETE FROM videos WHERE id = ?'
        );
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->channelsId,
            $this->name,
            $this->likes,
            $this->dislikes
        ]);

        $this->id = (int) $this->PDO->lastInsertId();
        return $this->id;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStatement->execute([
            ':ChannelsId'   => $this->channelsId,
            ':Name'         => $this->name,
            ':Likes'        => $this->likes,
            ':Dislikes'     => $this->dislikes,
            ':Id'           => $this->id
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $this->id = null;
        return $this->deleteStatement->execute([
            $this->id
        ]);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getChannelsId(): ?int
    {
        return $this->channelsId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getLikes(): ?int
    {
        return $this->likes;
    }

    /**
     * @return int|null
     */
    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int $channelsId
     * @return void
     */
    public function setChannelsId(int $channelsId): void
    {
        $this->channelsId = $channelsId;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return void
     */
    public function addLike(): void
    {
        $this->likes = 1;
    }

    /**
     * @return void
     */
    public function addDislikes(): void
    {
        $this->dislikes = 1;
    }
}
