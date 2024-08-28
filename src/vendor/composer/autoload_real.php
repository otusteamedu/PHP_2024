<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInited71f71dd217156c9e38d1ce0c6ace5d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInited71f71dd217156c9e38d1ce0c6ace5d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInited71f71dd217156c9e38d1ce0c6ace5d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInited71f71dd217156c9e38d1ce0c6ace5d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
