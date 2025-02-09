<?php

namespace KRudenko\Otus\Core;

use Dotenv\Dotenv;
use KRudenko\Otus\Entity\User;
use KRudenko\Otus\Exceptions\DatabaseException;
use KRudenko\Otus\Migration\Migrate1;
use KRudenko\Otus\Database\ActiveRecord;
use KRudenko\Otus\Database\Connection;
use PDOException;

class Kernel
{
    public function boot(): void
    {
        $this->loadEnvironment();
        $this->initDatabase();
    }

    public function handleCommand(): string
    {
        $command = $_SERVER['argv'][1] ?? null;
        $arg = $_SERVER['argv'][2] ?? null;
        $options = $this->getOpt();

        switch ($command) {
            case 'migrate':
                switch ($arg) {
                    case 'up':
                        (new Migrate1())->up();
                        return "Migrate up exec\n";
                    case 'down':
                        (new Migrate1())->down();
                        return "Migrate down exec\n";
                    default:
                        return "Usage:\n"
                            . "migrate up\n"
                            . "migrate down\n";
                }

            case 'get_users':
                $limit = (int)($options['limit'] ?? 100);
                $offset = (int)($options['offset'] ?? 0);
                $users = User::findAll($limit, $offset);
                /** @var User $user */
                foreach ($users as $user) {
                    echo "ID: $user->id, Name: $user->name, Email: $user->email\n";
                }
                return "Show all users\n";

            case 'get_user':
                if (is_numeric($arg)) {
                    /** @var User $user */
                    $user = User::findById($arg);
                    if ($user) {
                        return "ID: $user->id, Name: $user->name, Email: $user->email\n";
                    } else {
                        return "User $arg not found\n";
                    }
                }
                return "Pass the user ID\n";

            case 'add_user':
                if ($options['add']) {
                    $data = str_replace("'", '"', $options['add']);
                    $data = json_decode($data, true);
                    if (is_array($data)) {
                        $newUser = new User($data);
                        $newUser->save();
                        return "ID: $newUser->id, Name: $newUser->name, Email: $newUser->email\n";
                    } else {
                        return "Error data user\n";
                    }
                }
                return "Use option --add=\"{'name': 'test', 'email': 'example@test.test'}\"\n";

            case 'update_user':
                if ($options['update']) {
                    if (is_numeric($arg)) {
                        /** @var User $user */
                        $user = User::findById($arg);
                        if (!$user) {
                            return "User $arg not found\n";
                        }
                    } else {
                        return "Pass the user ID\n";
                    }
                    $data = str_replace("'", '"', $options['update']);
                    $data = json_decode($data, true);
                    if (is_array($data)) {
                        foreach ($data as $key => $value) {
                            if (property_exists($user, $key)) {
                                $user->{$key} = $value;
                            }
                        }
                        $user->save();
                        return "ID: $user->id, Name: $user->name, Email: $user->email\n";
                    } else {
                        return "Error data user\n";
                    }
                }
                return "Use pass the user ID and option --update=\"{'name': 'test', 'email': 'example@test.test'}\"\n";

            case 'delete_user':
                if (is_numeric($arg)) {
                    /** @var User $user */
                    $user = User::findById($arg);
                    if ($user) {
                        $user->delete();
                        return "User $arg is deleted\n";
                    } else {
                        return "User $arg not found\n";
                    }
                }
                return "Pass the user ID\n";

            default:
                return "Usage:\n"
                    . "php index.php migrate up\n"
                    . "php index.php get_users --limit=100 --offset=0\n"
                    . "php index.php get_user 1\n"
                    . "php index.php add_user --add='JSON'\n"
                    . "php index.php update_user 1 --update='JSON'\n"
                    . "php index.php delete_user 2\n"
                    . "php index.php migrate down\n";
        }
    }

    private function loadEnvironment(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
    }

    private function initDatabase(): void
    {
        try {
            $connection = Connection::connect();
            ActiveRecord::setConnection($connection);
        } catch (PDOException $e) {
            throw new DatabaseException("Database connection failed: " . $e->getMessage());
        }
    }

    private function getOpt(): array
    {
        $options = array();
        foreach (array_slice($_SERVER["argv"], 2) as $arg) {
            if (preg_match('@--(.+)=(.+)@', $arg, $matches)) {
                $key = $matches[1];
                $value = $matches[2];
                $options[$key] = $value;
            } else if (preg_match("@-(.)(.)@", $arg, $matches)) {
                $key = $matches[1];
                $value = $matches[2];
                $options[$key] = $value;
            }
        }

        return $options;
    }
}
