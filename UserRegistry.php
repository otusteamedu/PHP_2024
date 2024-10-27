<?php
// Класс UserRegistry, реализующий паттерн Identity Map.
class UserRegistry {
    private static $users = [];

    public static function add(User $user) {
        self::$users[$user->getId()] = $user;
    }

    public static function get($id) {
        return self::$users[$id] ?? null;
    }
}
