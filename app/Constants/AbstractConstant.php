<?php

declare(strict_types=1);

namespace App\Constants;

abstract class AbstractConstant
{
    public static function getConstants(): array
    {
        return (new \ReflectionClass(new static))->getConstants();
    }
}
