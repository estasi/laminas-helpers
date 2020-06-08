<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\PDOConnect\Factory;

use Estasi\LaminasHelpers\PDOConnect\{
    ConfigProvider,
    Driver\MySql,
    Interfaces\PDOConnectDriver
};
use Estasi\PluginManager\ReflectionPlugin;
use Interop\Container\ContainerInterface;
use InvalidArgumentException;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use PDO;
use RuntimeException;

use function class_exists;
use function is_array;
use function is_string;
use function is_subclass_of;
use function preg_match;
use function substr;
use function substr_compare;

/**
 * Class AbstractPDOConnect
 *
 * @package Estasi\LaminasHelpers\PDOConnect\Factory
 */
final class AbstractPDOConnect implements AbstractFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return (bool)$this->getPDOConfig($container, $requestedName);
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $PDOConfig = $this->getPDOConfig($container, $requestedName);

        if ($PDOConfig instanceof PDOConnectDriver) {
            return $PDOConfig($requestedName);
        }

        if (is_array($PDOConfig)) {
            return $this->createPDOFromArr($PDOConfig, $requestedName);
        }

        if (is_string($PDOConfig)) {
            return $this->createPDOFromStr($PDOConfig, $requestedName);
        }

        throw new RuntimeException('The PDO object could not be created. Invalid data received!');
    }

    /**
     * @param \Interop\Container\ContainerInterface $container
     * @param string                                $requestedName
     *
     * @return string|array|bool
     */
    private function getPDOConfig(ContainerInterface $container, string $requestedName)
    {
        return $container->get('config')[ConfigProvider::class][$requestedName];
    }

    /**
     * @param array  $PDOConfig
     * @param string $requestedName
     *
     * @return \PDO
     * @throws \ReflectionException
     * @throws \RuntimeException
     */
    private function createPDOFromArr(array $PDOConfig, string $requestedName): PDO
    {
        if (isset($PDOConfig[PDOConnectDriver::class])) {
            $driver = $PDOConfig[PDOConnectDriver::class];
            if ($driver instanceof PDOConnectDriver) {
                return $driver;
            }
            if (false === is_string($driver)) {
                throw new InvalidArgumentException(
                    'The PDO object could not be created.'
                    . ' The key value "PDOConnectDriver::class" must be an object'
                    . ' implementing the interface "Estasi\LaminasHelpers\PDOConnect\Interfaces\PDOConnectDriver"'
                    . ' or a string with the name of the PDO driver "pdo_*".'
                );
            }
            $driver = ['pdo_mysql' => MySql::class][$driver];
            if ($this->isPDOConnectDriver($driver)) {
                unset($PDOConfig[PDOConnectDriver::class]);
                /** @var PDOConnectDriver $driver */
                $driver = (new ReflectionPlugin($driver))->newInstanceArgs($PDOConfig);

                return $driver($requestedName);
            }
        } elseif (isset($PDOConfig['dsn']) && $this->isValidDSN($PDOConfig['dsn'])) {
            return new PDO(
                $this->checkDbnameInDsn($PDOConfig['dsn'], $requestedName),
                $PDOConfig[PDOConnectDriver::OPT_USERNAME],
                $PDOConfig[PDOConnectDriver::OPT_PASSWD],
                $PDOConfig[PDOConnectDriver::OPT_OPTIONS]
            );
        }

        throw new RuntimeException(
            'The PDO object could not be created.'
            . ' The required keys "PDOConnectDriver::class"'
            . ' or "dsn" are missing, or their values are incorrect.'
        );
    }

    /**
     * @param string $PDOConfig
     * @param string $requestedName
     *
     * @return \PDO
     * @throws \RuntimeException
     */
    private function createPDOFromStr(string $PDOConfig, string $requestedName): PDO
    {
        if ($this->isValidDSN($PDOConfig)) {
            return new PDO($this->checkDbnameInDsn($PDOConfig, $requestedName));
        }

        if ($this->isPDOConnectDriver($PDOConfig)) {
            return (new $PDOConfig())($requestedName);
        }

        throw new RuntimeException(
            'The PDO object could not be created. The string must be in the "dsn" format of the required driver'
            . ' or the name of the class implementing the interface "Estasi\LaminasHelpers\PDOConnect\Interfaces\PDOConnectDriver".'
        );
    }

    private function isPDOConnectDriver($PDODriver)
    {
        return class_exists($PDODriver) && is_subclass_of($PDODriver, PDOConnectDriver::class);
    }

    private function isValidDSN(string $dsn): bool
    {
        return (bool)preg_match('`^(?:mysql|pgsql|sqlite)\x3A`', $dsn);
    }

    private function checkDbnameInDsn(string $dsn, string $dbname): string
    {
        if (!preg_match('`dbname\x3D.*?(?=\x3B|$)`', $dsn)) {
            if (0 === substr_compare($dsn, ';', -1)) {
                $dsn = substr($dsn, 0, -1);
            }
            $dsn .= sprintf(';dbname=%s;', $dbname);
        }

        return $dsn;
    }
}
