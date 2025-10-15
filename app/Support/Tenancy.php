<?php

namespace App\Support;

class Tenancy
{
    private static ?int $tenantId = null;

    public static function setTenantId(?int $id): void
    {
        self::$tenantId = $id;
    }

    public static function tenantId(): ?int
    {
        return self::$tenantId;
    }
}
