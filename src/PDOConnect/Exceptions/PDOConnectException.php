<?php

declare(strict_types=1);

namespace Estasi\LaminasHelpers\PDOConnect\Exceptions;

use RuntimeException;
use Throwable;

use function preg_match;
use function strstr;

/**
 * Class PDOConnectException
 *
 * @package Estasi\LaminasHelpers\PDOConnect\Exceptions
 */
class PDOConnectException extends RuntimeException
{
    /**
     * @inheritDoc
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if (strstr($message, 'SQLSTATE[')) {
            /** @noinspection RegExpRedundantEscape */
            preg_match('/SQLSTATE\[(\w+)\]\s\[(\w+)\]\s(.*)/', $message, $matches);
            $code    = (int)(preg_match('`^H([TY])000$`i', $matches[1]) ? $matches[2] : $matches[1]);
            $message = $matches[3];
        } else {
            $message = 'Unknown error!';
        }

        parent::__construct($message, $code, $previous);
    }
}
