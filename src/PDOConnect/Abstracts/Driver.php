<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\PDOConnect\Abstracts;

use Ds\Map;
use Estasi\LaminasHelpers\PDOConnect\Exceptions\PDOConnectException;
use Estasi\LaminasHelpers\PDOConnect\Interfaces\PDOConnectDriver;
use Estasi\Utility\Assert;
use PDO;
use PDOException;

use function array_flip;
use function compact;
use function preg_replace;
use function sprintf;

/**
 * Class Driver
 *
 * @package Estasi\LaminasHelpers\PDOConnect\Abstracts
 */
abstract class Driver implements PDOConnectDriver
{
    private Map $params;

    /**
     * Returns the driver's pdo name "pdo_*"
     *
     * @return string
     */
    abstract protected function getPDODriverName(): string;

    /**
     * Returns valid dsn string elements for the driver
     *
     * @return array
     */
    abstract protected function getPDODriverValidElements(): array;

    /**
     * @inheritDoc
     */
    public function __construct(
        string $host = self::LOCALHOST,
        ?int $port = self::DEFAULT_PORT,
        ?string $username = self::DEFAULT_USERNAME,
        ?string $passwd = self::WITHOUT_PASSWD,
        ?iterable $options = self::WITHOUT_PDO_OPTIONS
    ) {
        Assert::extensionLoaded($this->getPDODriverName());
        $this->params = new Map(compact('host', 'port', 'username', 'passwd', 'options'));
    }

    /**
     * @inheritDoc
     */
    public function __invoke(string $dbname): PDO
    {
        try {
            $pdo = new PDO(
                $this->createDSN($dbname),
                $this->params->get(self::OPT_USERNAME, null),
                $this->params->get(self::OPT_PASSWD, null),
                $this->params->get(self::OPT_OPTIONS, null)
            );
        } catch (PDOException $PDOException) {
            throw new PDOConnectException($PDOException->getMessage(), $PDOException->getCode(), $PDOException);
        }

        return $pdo;
    }

    private function createDSN(string $dbname)
    {
        $this->params->putAll(compact('dbname'));

        return $this->params->intersect(new Map(array_flip($this->getPDODriverValidElements())))
                            ->filter()
                            ->reduce(
                                fn($carry, $name, $value): string => sprintf('%s%s=%s;', $carry, $name, $value),
                                preg_replace('`^pdo\x5F([a-z]+)`', '$1:', $this->getPDODriverName())
                            );
    }
}
