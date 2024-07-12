<?php

namespace Naimushina\Webservers;

use Predis\Client;
use Predis\ClientInterface;
use SessionHandlerInterface;

class RedisSessionHandler implements SessionHandlerInterface
{
    /**
     * Время хранения - 30 минут
     * @var int
     */
    public $ttl = 1800;
    /**
     * Клиент Редис для хранения сессий
     * @var
     */
    protected $db;
    /**
     * @var mixed|string
     */
    protected $prefix;

    /**
     * @param $db
     * @param string $prefix
     */
    public function __construct($db, string $prefix = 'PHPSESSID:')
    {
        $this->db = $db;
        $this->prefix = $prefix;
    }

    /**
     * @param $savePath
     * @param $sessionName
     * @return bool
     */
    public function open($savePath, $sessionName): bool
    {
        //All data set in construct
        return true;
    }

    /**
     * @return void
     */
    public function close()
    {
        $this->db = null;
        unset($this->db);
    }

    /**
     * @param $id
     * @return false|string
     */
    public function read($id)
    {
        $id = $this->prefix . $id;
        $sessData = $this->db->get($id);
        $this->db->expire($id, $this->ttl);
        return $sessData;
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function write($id, $data)
    {
        $id = $this->prefix . $id;
        $this->db->set($id, $data);
        $this->db->expire($id, $this->ttl);
    }

    /**
     * @param $id
     * @return void
     */
    public function destroy($id)
    {
        $this->db->del($this->prefix . $id);
    }

    /**
     * @param $max_lifetime
     * @return void
     */
    public function gc($max_lifetime)
    {
        $this->db->del($this->prefix);
    }
}
