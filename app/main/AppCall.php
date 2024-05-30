<?php


namespace App\main;


use App\controllers\GoodAdminController;
use App\controllers\OrderAdminController;
use App\Repositories\BasketRepository;
use App\Repositories\GoodAuthRepository;
use App\repositories\GoodRepository;
use App\Repositories\UserAuthRepository;
use App\repositories\UserRepository;
use App\services\BasketService;
use App\services\DB;
use App\services\GoodService;
use App\services\OrderService;
use App\services\renders\IRender;
use App\services\CRUDService;
use App\services\UserService;
use App\traits\TSingleton;

/**
 * Class AppCall
 * @package App\main
 * @property IRender render
 * @property DB db
 * @property UserRepository userRepository
 * @property GoodRepository goodRepository
 * @property CRUDService CRUDService
 * @property BasketService  BasketService
 * @property UserService  userService
 * @property OrderService  orderService
 * @property GoodService  goodService
 * @property BasketService basketService
 * @property mixed|null orderRepository
 * @property GoodAuthRepository goodAuthRepository
 * @property UserAuthRepository userAuthRepository
 * @property UserAuthRepository orderAuthRepository
 * @property GoodAdminController goodAdminRepository
 * @property GoodAdminController userAdminRepository
 * @property OrderAdminController orderAdminRepository
 * @property BasketRepository basketRepository
 *
 */
class AppCall
{
    use TSingleton;

    protected $components = [];
    protected $config;
    private $orderAuthRepository;

    public static function call(): AppCall
    {
        return static::getInstance();
    }

    public function getConfig(array $config)
    {
        $this->config = $config;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->components)) {
            return $this->components[$name];
        }
        if (!array_key_exists($name, $this->config["components"])) {
            return null;
        }

        $className = $this->config['components'][$name]['class'];

        if (array_key_exists("config", $this->config['components'][$name])) {
            $config = $this->config['components'][$name]['config'];
            $component = new $className($config);
        } else {
            $component = new $className;
        }
        $this->components[$name] = $component;
        return $component;
    }
}