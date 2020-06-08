<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Validator;

use Estasi\PluginManager\Traits\PluginManager as PluginManagerTrait;
use Estasi\Validator\{
    Interfaces\PluginManager as ValidatorPluginManagerInterface,
    Traits\PluginManager as ValidatorPluginManagerTrait
};
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * Class PluginManager
 *
 * @package Estasi\LaminasHelpers\Validator
 */
final class PluginManager extends AbstractPluginManager implements ValidatorPluginManagerInterface
{
    use PluginManagerTrait;
    use ValidatorPluginManagerTrait;

    /**
     * @inheritDoc
     */
    public function get($name, ?array $options = null)
    {
        return $this->build($name, $options);
    }
}
