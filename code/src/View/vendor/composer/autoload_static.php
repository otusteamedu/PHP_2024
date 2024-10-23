<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdf9161b326a12a9d600e837789de020b
{
    public static $prefixesPsr0 = array (
        'L' => 
        array (
            'LucidFrame\\' => 
            array (
                0 => __DIR__ . '/..' . '/phplucidframe/console-table/src',
            ),
            'LucidFrameTest\\' => 
            array (
                0 => __DIR__ . '/..' . '/phplucidframe/console-table/tests',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitdf9161b326a12a9d600e837789de020b::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitdf9161b326a12a9d600e837789de020b::$classMap;

        }, null, ClassLoader::class);
    }
}
