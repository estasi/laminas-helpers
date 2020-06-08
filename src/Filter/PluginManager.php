<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Filter;

use Estasi\Filter\{
    Interfaces\PluginManager as FilterPluginManagerInterface,
    Traits\PluginManager as FilterPluginManagerTrait
};
use Estasi\PluginManager\Traits\PluginManager as PluginManagerTrait;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * Class PluginManager
 *
 * @package Estasi\LaminasHelpers\Filter
 */
final class PluginManager extends AbstractPluginManager implements FilterPluginManagerInterface
{
    use PluginManagerTrait;
    use FilterPluginManagerTrait;

    /**
     * @inheritDoc
     */
    public function get($name, ?array $options = null)
    {
        return $this->build($name, $options);
    }
}
