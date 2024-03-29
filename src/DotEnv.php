<?php

namespace VarunS\PHPSleep;

class DotEnv
{
    public static function loadIfLocal() {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/.env';
        
        if(!file_exists($path) && count($_ENV) < 0) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        } else if (!file_exists($path)) {
            return;
        }

        if (!is_readable($path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $path));
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') !== 0) {

                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }
}


