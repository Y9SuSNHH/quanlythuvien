<?php

declare(strict_types=1);

namespace App\Constants;

final class OrderStatusConstant extends AbstractConstant
{
    public const NEW       = 1;
    public const COMPLETED = 2;
    public const SHIPPED   = 3;
    public const OVER_RENT = 4;

    public static function getLangByValue($value): string
    {
        $value = (int) $value;
        return match ($value) {
            self::NEW => 'Yêu cầu thuê sách',
            self::COMPLETED => 'Đã trả sách',
            self::OVER_RENT => 'Quá hạn trả sách',
            self::SHIPPED => 'Đã nhận sách',
            default => '',
        };
    }
}
