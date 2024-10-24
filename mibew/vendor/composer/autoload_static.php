<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit844451b48ae2e0ced60a851e0551e7b2
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '9a7cbd1d6e5aa7dd52aaebb422f6fade' => __DIR__ . '/..' . '/mibew/html5/src/HTML5.php',
        '2c102faa651ef8ea5874edb585946bce' => __DIR__ . '/..' . '/swiftmailer/swiftmailer/lib/swift_required.php',
    );

    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'UAParser\\' => 9,
        ),
        'T' => 
        array (
            'True\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\Yaml\\' => 23,
            'Symfony\\Component\\HttpFoundation\\' => 33,
            'Symfony\\Component\\Filesystem\\' => 29,
            'Stash\\' => 6,
        ),
        'J' => 
        array (
            'JustBlackBird\\HandlebarsHelpers\\' => 32,
        ),
        'C' => 
        array (
            'Composer\\CaBundle\\' => 18,
            'Canteen\\HTML5\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'UAParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/ua-parser/uap-php/src',
        ),
        'True\\' => 
        array (
            0 => __DIR__ . '/..' . '/true/punycode/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Symfony\\Component\\HttpFoundation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/http-foundation',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Stash\\' => 
        array (
            0 => __DIR__ . '/..' . '/tedivm/stash/src/Stash',
        ),
        'JustBlackBird\\HandlebarsHelpers\\' => 
        array (
            0 => __DIR__ . '/..' . '/mibew/handlebars.php-helpers/src',
        ),
        'Composer\\CaBundle\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/ca-bundle/src',
        ),
        'Canteen\\HTML5\\' => 
        array (
            0 => __DIR__ . '/..' . '/mibew/html5/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'v' => 
        array (
            'vierbergenlars\\SemVer\\' => 
            array (
                0 => __DIR__ . '/..' . '/vierbergenlars/php-semver/src',
            ),
            'vierbergenlars\\LibJs\\' => 
            array (
                0 => __DIR__ . '/..' . '/vierbergenlars/php-semver/src',
            ),
        ),
        'S' => 
        array (
            'Symfony\\Component\\Translation\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/translation',
            ),
            'Symfony\\Component\\Routing\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/routing',
            ),
            'Symfony\\Component\\Config\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/config',
            ),
        ),
        'H' => 
        array (
            'Handlebars' => 
            array (
                0 => __DIR__ . '/..' . '/mibew/handlebars.php/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'vierbergenlars\\SemVer\\Internal\\Comparator' => __DIR__ . '/..' . '/vierbergenlars/php-semver/src/vierbergenlars/SemVer/internal.php',
        'vierbergenlars\\SemVer\\Internal\\Exports' => __DIR__ . '/..' . '/vierbergenlars/php-semver/src/vierbergenlars/SemVer/internal.php',
        'vierbergenlars\\SemVer\\Internal\\G' => __DIR__ . '/..' . '/vierbergenlars/php-semver/src/vierbergenlars/SemVer/internal.php',
        'vierbergenlars\\SemVer\\Internal\\Range' => __DIR__ . '/..' . '/vierbergenlars/php-semver/src/vierbergenlars/SemVer/internal.php',
        'vierbergenlars\\SemVer\\Internal\\SemVer' => __DIR__ . '/..' . '/vierbergenlars/php-semver/src/vierbergenlars/SemVer/internal.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit844451b48ae2e0ced60a851e0551e7b2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit844451b48ae2e0ced60a851e0551e7b2::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit844451b48ae2e0ced60a851e0551e7b2::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit844451b48ae2e0ced60a851e0551e7b2::$classMap;

        }, null, ClassLoader::class);
    }
}
