<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\Form;

use Estasi\Form\Interfaces\Field;
use Laminas\ServiceManager\AbstractPluginManager;

/**
 * Class FieldsPluginManager
 *
 * @package Estasi\LaminasHelpers\form
 */
final class FieldsPluginManager extends AbstractPluginManager
{
    /**
     * @inheritDoc
     */
    public function __construct($configInstanceOrParentLocator = null, array $config = [])
    {
        parent::__construct($configInstanceOrParentLocator, $config);
        $this->sharedByDefault = false;
        $this->instanceOf      = Field::class;
    }
}
