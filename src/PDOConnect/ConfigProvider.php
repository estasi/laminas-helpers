<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\PDOConnect;

/**
 * Class ConfigProvider
 *
 * @package Estasi\LaminasHelpers\PDOConnect
 */
final class ConfigProvider implements \Estasi\LaminasHelpers\Interfaces\ConfigProvider
{

    /**
     * @inheritDoc
     */
    public function __invoke()
    {
        return [
            self::DEPENDENCIES => [
                self::DEPENDENCIES_ABSTRACT_FACTORIES => [Factory\AbstractPDOConnect::class],
            ],
            self::class        => [

            ],
        ];
    }
}
