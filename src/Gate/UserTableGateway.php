<?php

namespace VSukhov\Hw14\Gate;

use PDO;

class UserTableGateway
{
    private PDO $db;
    private IdentityMap $identityMap;

    public function __construct()
    {
        $host = getenv('DATABASE_HOST');
        $port = getenv('DATABASE_PORT');
        $dbname = getenv('DATABASE_NAME');
        $user = getenv('DATABASE_USER');
        $password = getenv('DATABASE_PASSWORD');

        $this->db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $this->identityMap = new IdentityMap();
    }

    public function getAllUsers(int $limit = 100, int $offset = 0): array
    {
        $statement = $this->db->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $user) {
            $this->identityMap->add($user['id'], $user);
        }

        return $results;
    }

    public function getUserById(int $id): ?array
    {
        if ($user = $this->identityMap->get($id)) {
            return $user;
        }

        $statement = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute([':id' => $id]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->identityMap->add($id, $user);
        }

        return $user;
    }
}
