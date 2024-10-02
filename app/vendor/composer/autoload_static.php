<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0131fc1cc7230d7c4d8b2188ccc2a03a
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0131fc1cc7230d7c4d8b2188ccc2a03a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0131fc1cc7230d7c4d8b2188ccc2a03a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0131fc1cc7230d7c4d8b2188ccc2a03a::$classMap;

        }, null, ClassLoader::class);
    }
}
