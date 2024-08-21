<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case InProcess = 'In Process';
    case Paid = 'Paid';
    case Shipped = 'Shipped';
    case Delivered = 'Delivered';
    case Cancelled = 'Cancelled';

    public static function findByKey(string $key)
    {
        return constant("self::$key");
    }

    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $prop) {
            $values[] = $prop->value;
        }

        return $values;
    }
}
