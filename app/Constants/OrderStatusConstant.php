<?php

declare(strict_types=1);

namespace App\Constants;

final class OrderStatusConstant extends AbstractConstant
{
    public const NEW       = 1;
    public const COMPLETED = 2;
    public const SHIPPED   = 3;

    public static function getLangByValue($value): string
    {
        return match ($value) {
            self::NEW => 'Mới tạo',
            self::COMPLETED => 'Hoàn thành',
            self::SHIPPED => 'Đã giao',
            default => '',
        };
    }
}
