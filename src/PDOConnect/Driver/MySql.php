<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\PDOConnect\Driver;

use Estasi\LaminasHelpers\PDOConnect\Abstracts\Driver;

/**
 * Class MySql
 *
 * @package Estasi\LaminasHelpers\PDOConnect\Driver
 */
final class MySql extends Driver
{
    /**
     * @inheritDoc
     */
    protected function getPDODriverName(): string
    {
        return 'pdo_mysql';
    }

    /**
     * @inheritDoc
     */
    protected function getPDODriverValidElements(): array
    {
        return [self::OPT_HOST, self::OPT_PORT, 'dbname', 'charset'];
    }
}
