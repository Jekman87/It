<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55f02320bccb1addc343c3e6dec7d8e1
{
    public static $prefixesPsr0 = array (
        'Z' => 
        array (
            'Zend_' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zendframework1/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit55f02320bccb1addc343c3e6dec7d8e1::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}