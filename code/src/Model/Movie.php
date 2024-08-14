<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Model;

use DateTime;
use PDO;

class Movie
{
    /** @var integer|null */
    public ?int $id = null;
    /** @var string */
    public string $title;
    /** @var string */
    public string $description;
    /** @var integer */
    public int $publishYear;
    /** @var DateTime|null */
    public ?DateTime $deletedAt = null;

    /**
     * @param PDO $pdo
     */
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param boolean $force
     * @return void
     */
    public function delete(bool $force = false)
    {
        if ($force) {
            $sth = $this->pdo->prepare('DELETE FROM movies WHERE id=:id');
            $sth->execute([':id' => $this->id]);
        } else {
            $this->deletedAt = new DateTime();
            $this->update();
        }
    }

    /**
     * @return void
     */
    public function update()
    {
        $sth = $this->pdo->prepare(
            'UPDATE movies SET title=:title, description=:description, publish_year=:publishYear, deleted_at=:deletedAt WHERE id=:id'
        );
        $sth->execute([
            ':id' => $this->id,
            ':title' => $this->title,
            ':description' => $this->description,
            'publishYear' => $this->publishYear,
            ':deletedAt' => !is_null($this->deletedAt) ? $this->deletedAt->format('Y-m-d H:m:s') : null,
        ]);
    }

    /**
     * @return void
     */
    public function insert()
    {
        $sth = $this->pdo->prepare(
            'INSERT INTO movies(title, description, publish_year, deleted_at)VALUES(:title, :description, :publishYear, :deletedAt)'
        );
        $res = $sth->execute([
            ':title' => $this->title,
            ':description' => $this->description,
            'publishYear' => $this->publishYear,
            ':deletedAt' => !is_null($this->deletedAt) ? $this->deletedAt->format('Y-m-d H:m:s') : null,
        ]);
        $this->id = (int)$this->pdo->lastInsertId('movies_id_seq');
    }

    /**
     * @return void
     */
    public function save()
    {
        if (is_null($this->id)) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /**
     * @param array $data
     * @return void
     */
    public function fromArray(array $data)
    {
        if (array_key_exists('id', $data)) {
            $this->id = $data['id'];
        }

        if (array_key_exists('title', $data)) {
            $this->title = $data['title'];
        }

        if (array_key_exists('description', $data)) {
            $this->description = $data['description'];
        }

        if (array_key_exists('publish_year', $data)) {
            $this->publishYear = $data['publish_year'];
        }

        if (array_key_exists('deleted_at', $data)) {
            if (is_string($data['deleted_at'])) {
                $this->deletedAt = new DateTime($data['deleted_at']);
            } else {
                $this->deletedAt = $data['deleted_at'];
            }
        }
    }
}
