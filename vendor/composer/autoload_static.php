<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5379105c027af5c8a03d2cbf96a6a6a4
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5379105c027af5c8a03d2cbf96a6a6a4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5379105c027af5c8a03d2cbf96a6a6a4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5379105c027af5c8a03d2cbf96a6a6a4::$classMap;

        }, null, ClassLoader::class);
    }
}
