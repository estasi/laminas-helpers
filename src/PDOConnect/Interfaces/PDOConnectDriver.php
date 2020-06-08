<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\PDOConnect\Interfaces;

use PDO;

/**
 * Interface PDOConnectDrivers
 *
 * @package Estasi\LaminasHelpers\PDOConnect\Interfaces
 */
interface PDOConnectDriver
{
    // names of constructor parameters to create via the factory
    public const OPT_HOST     = 'host';
    public const OPT_PORT     = 'port';
    public const OPT_USERNAME = 'username';
    public const OPT_PASSWD   = 'passwd';
    public const OPT_OPTIONS  = 'options';
    // default values for constructor parameters
    public const LOCALHOST           = '127.0.0.1';
    public const DEFAULT_PORT        = null;
    public const DEFAULT_USERNAME    = null;
    public const WITHOUT_PASSWD      = null;
    public const WITHOUT_PDO_OPTIONS = null;

    /**
     * Creates a PDO instance representing a connection to a database
     *
     * @param string $dbname The name of the database.
     *
     * @return \PDO
     */
    public function __invoke(string $dbname): PDO;

    /**
     * PDOConnectDriver constructor.
     *
     * @param string        $host     The hostname on which the database server resides.
     * @param int|null      $port     The port number where the database server is listening.
     * @param string|null   $username The user name for the DSN string. This parameter is optional for some PDO drivers.
     * @param string|null   $passwd   The password for the DSN string. This parameter is optional for some PDO drivers.
     * @param iterable|null $options  A key=>value array of driver-specific connection options.
     */
    public function __construct(
        string $host = self::LOCALHOST,
        ?int $port = self::DEFAULT_PORT,
        ?string $username = self::DEFAULT_USERNAME,
        ?string $passwd = self::WITHOUT_PASSWD,
        ?iterable $options = self::WITHOUT_PDO_OPTIONS
    );
}
