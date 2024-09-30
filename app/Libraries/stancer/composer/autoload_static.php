<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1353193a66fafae3d54c1a5b13edf458
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stancer\\' => 8,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stancer\\' => 
        array (
            0 => __DIR__ . '/..' . '/stancer/stancer/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1353193a66fafae3d54c1a5b13edf458::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1353193a66fafae3d54c1a5b13edf458::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1353193a66fafae3d54c1a5b13edf458::$classMap;

        }, null, ClassLoader::class);
    }
}
