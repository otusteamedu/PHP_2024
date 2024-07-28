<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class QueueReport
{
    private readonly ?int $id;

    private array $modifiedFields = [];
    public function __construct(
        private string $uid,
        private string $status,
        private ?string $file_path,
        private string $created_at,
        private string $updated_at,
    )
    {
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at): void
    {
        $this->modifiedFields['updated_at'] = $updated_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->modifiedFields['status'] = $status;
        $this->status = $status;
    }

    /**
     * @return string | null
     */
    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    /**
     * @param string $file_path
     */
    public function setFilePath(string $file_path): void
    {
        $this->modifiedFields['file_path'] = $file_path;
        $this->file_path = $file_path;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->modifiedFields['created_at'] = $created_at;
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid(string $uid): void
    {
        $this->modifiedFields['uid'] = $uid;
        $this->uid = $uid;
    }

    public function getModifiedFields(): array
    {
        return $this->modifiedFields;
    }
}
