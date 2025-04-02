<?php

namespace App\Gates;

use App\Models\User;
use Illuminate\Support\Collection;
class UserGateway
{
    protected $users = []; // Это будет наш Identity Map

    public function findMany(array $ids): Collection
    {
        // Получаем пользователей из базы данных
        $users = User::whereIn('id', $ids)->get();

        // Заполняем Identity Map
        foreach ($users as $user) {
            $this->users[$user->id] = $user;
        }

        return $users;
    }

    public function getUserById(int $id): ?User
    {
        // Проверьте, есть ли пользователь в Identity Map
        if (isset($this->users[$id])) {
            return $this->users[$id];
        }

        // Если его нет, извлеките из базы данных
        $user = User::find($id);

        // Если нашли, добавьте в Identity Map
        if ($user) {
            $this->users[$id] = $user;
        }

        return $user;
    }
}
