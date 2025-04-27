<?php
namespace Src;
use PDO;
class StatusStorage
{
    private static function db()
    {
        return new PDO('pgsql:host=postgres;dbname=mypgdb', 'user', 'password');
    }
    public static function createPending(): int
    {
        $db = self::db();
        $stmt = $db->prepare('INSERT INTO requests (status) VALUES (\'pending\') RETURNING id');
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    public static function getStatus(int $id): ?string
    {
        $db = self::db();
        $stmt = $db->prepare('SELECT status FROM requests WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $status = $stmt->fetchColumn();
        return $status ?: null;
    }

    public static function updateStatus(int $id, string $status)
    {
        $db = self::db();
        $stmt = $db->prepare('UPDATE requests SET status = :status WHERE id = :id');
        $stmt->execute(['status' => $status, 'id' => $id]);
    }
}