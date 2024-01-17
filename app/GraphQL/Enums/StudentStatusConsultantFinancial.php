<?php

namespace App\GraphQL\Enums;

class StudentStatusConsultantFinancial 
{
    public const OK = 'ok';
    public const REFUSED = 'refused';
    public const FIRED = 'fired';
    public const REFUSE_PENDING = 'refuse_pending';
    public const FIRE_PENDING = 'fire_pending';
    public const FINANCIAL_PENDING = 'financial_pending';

    public static function getValues(): array
    {
        return [
            self::OK,
            self::REFUSED,
            self::FIRED,
            self::FINANCIAL_PENDING,
            self::REFUSE_PENDING,
            self::FIRE_PENDING,
        ];
    }
}