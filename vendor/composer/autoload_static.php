<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3509bae1b43f46f35451983aa30aec82
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SigeTurbo\\SMS\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SigeTurbo\\SMS\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3509bae1b43f46f35451983aa30aec82::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3509bae1b43f46f35451983aa30aec82::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
