<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite27c77912c03c3e14e8c050699c15ba5
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite27c77912c03c3e14e8c050699c15ba5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite27c77912c03c3e14e8c050699c15ba5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite27c77912c03c3e14e8c050699c15ba5::$classMap;

        }, null, ClassLoader::class);
    }
}
