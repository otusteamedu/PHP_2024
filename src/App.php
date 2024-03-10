<?php

declare(strict_types=1);


namespace Main;


class App
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * App constructor.
     */
    protected function __construct()
    {
    }


    protected function __clone()
    {
    }


    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Может существовать только 1 экземпляр приложения");
    }


    /**
     * @param array $config
     * @return static
     */
    public static function getInstance(array $config = []): self
    {
        if (empty(self::$instance)) {
            self::$instance = new static($config);
        }

        return self::$instance;
    }


    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $emailTest = new EmailTest();
        $emailTest->runTest();
    }


    protected function getEmailList()
    {

    }

}