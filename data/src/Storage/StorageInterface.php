<?php
declare(strict_types=1);

namespace App\Storage;


interface StorageInterface
{
    public function addEvent(array $arguments);
    public function deleteEvents();
    public function getEvent(array $param);

}