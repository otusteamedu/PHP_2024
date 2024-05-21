<?php
declare(strict_types=1);
namespace App\Domain\TransportInterface;

interface TransportInterface
{
    public function prepareServer();
    public function prepareClient();
    public function getExitKey(): string;
    public function accept();
    public function write(string $msg);
    public function read();
    public function close();
}