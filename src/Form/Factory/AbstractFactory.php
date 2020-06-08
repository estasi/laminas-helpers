<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form\Factory;

use Ds\Map;
use Ds\Vector;
use Estasi\LaminasHelpers\Form\ConfigProvider;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

use function array_key_exists;
use function md5;

/**
 * Class AbstractFactory
 *
 * @package Estasi\LaminasHelpers\Form\Factory
 */
abstract class AbstractFactory implements AbstractFactoryInterface
{
    private static array $classNameCache = [];

    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     *
     * @param string                                $formOrField
     *
     * @return string|null
     */
    protected function getClassname(ContainerInterface $container, string $requestedName, string $formOrField): ?string
    {
        $hash = md5($requestedName);
        if (array_key_exists($hash, self::$classNameCache)) {
            return self::$classNameCache[$hash];
        }

        $formsConfig = $container->get('config')[ConfigProvider::class][$formOrField];
        $invokables  = new Vector($formsConfig[ConfigProvider::DEPENDENCIES_INVOKABLES] ?? []);
        $factories   = new Map($formsConfig[ConfigProvider::DEPENDENCIES_FACTORIES] ?? []);
        $aliases     = new Map($formsConfig[ConfigProvider::DEPENDENCIES_ALIASES] ?? []);

        if ($aliases->hasKey($requestedName)) {
            $requestedName = $aliases->get($requestedName);
        }

        if (false !== $invokables->find($requestedName)) {
            return self::$classNameCache[$hash] = $requestedName;
        }

        if ($factories->hasKey($requestedName)) {
            return self::$classNameCache[$hash] = $factories->get($requestedName);
        }

        return null;
    }
}
