<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form;

use Estasi\Form\Interfaces\Form;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * Class PluginManager
 *
 * @method Form get($name, array $options = null)
 * @package Estasi\LaminasHelpers\Form
 */
final class FormsPluginManager extends AbstractPluginManager
{
    /**
     * @inheritDoc
     */
    public function __construct($configInstanceOrParentLocator = null, array $config = [])
    {
        parent::__construct($configInstanceOrParentLocator, $config);
        $this->sharedByDefault = false;
        $this->instanceOf      = Form::class;
    }
}
