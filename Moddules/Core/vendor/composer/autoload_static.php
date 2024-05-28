<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7fbb38202e68b3dafc87a8c77e06a945
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\Core\\Tests\\' => 19,
            'Modules\\Core\\Database\\Seeders\\' => 30,
            'Modules\\Core\\Database\\Factories\\' => 32,
            'Modules\\Core\\App\\' => 17,
            'Modules\\Core\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Modules\\Core\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Modules\\Core\\Database\\Seeders\\' => 
        array (
            0 => __DIR__ . '/../..' . '/database/seeders',
        ),
        'Modules\\Core\\Database\\Factories\\' => 
        array (
            0 => __DIR__ . '/../..' . '/database/factories',
        ),
        'Modules\\Core\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Modules\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7fbb38202e68b3dafc87a8c77e06a945::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7fbb38202e68b3dafc87a8c77e06a945::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7fbb38202e68b3dafc87a8c77e06a945::$classMap;

        }, null, ClassLoader::class);
    }
}