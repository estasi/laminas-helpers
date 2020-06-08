# PDO Connect
Plugin Estasi PDO Connect for connecting to a database in the Laminas environment

## Usage

Connect the "\Estasi\LaminasHelpers\PDOConnect\ConfigProvider" class in the file "config\config.php"
```php
<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;

$aggregator = new ConfigAggregator(
    [
        //...
        \Estasi\LaminasHelpers\PDOConnect\ConfigProvider::class,
        //...
    ]
);
```
In the "config\autoload" directory, create a php file with settings, for example, "pdo_connect.local.php"
```php
<?php

declare(strict_types=1);

use Estasi\LaminasHelpers\PDOConnect\Driver\MySql;
use Estasi\LaminasHelpers\PDOConnect\Interfaces\PDOConnectDriver;

return [
    \Estasi\LaminasHelpers\PDOConnect\ConfigProvider::class => [
        // "dbname" can be omitted explicitly if the key is the DB name
        'my_dbname_1' => 'mysql:host=127.0.0.1;port=3306;user=root;password=root;charset=utf8',
        'my_dbname_2' => [
            'dsn' => 'mysql:host=127.0.0.1;port=3306;user=root;password=root;charset=utf8',
            // 'username' => '', if necessary and absent in the dsn
            // 'passwd' => '', if necessary and absent in the dsn
            'options' => [/* A key=>value array of driver-specific connection options. */]
        ],
        'my_dbname_3' => new MySql(MySql::LOCALHOST, MySql::DEFAULT_PORT, 'root'),
        'my_dbname_4' => [
            PDOConnectDriver::class => new MySql(MySql::LOCALHOST, MySql::DEFAULT_PORT, 'root'),
        ],
        'my_dbname_5' => [
            PDOConnectDriver::class => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'username' => 'root',
        ],
        'my_dbname_6' => PDOConnectDriver::class
    ]
];
```