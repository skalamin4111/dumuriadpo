<?php

namespace App\Enums;

enum RoleName: string
{
    case SuperAdmin = 'Super Admin';
    case Admin = 'Admin';
    case Manager = 'Manager';
    case Supervisor = 'Supervisor';
    case Employee = 'Employee';
    case Auditor = 'Auditor';

    public static function hierarchy(): array
    {
        return [
            self::SuperAdmin->value => 100,
            self::Admin->value => 80,
            self::Manager->value => 60,
            self::Supervisor->value => 50,
            self::Employee->value => 20,
            self::Auditor->value => 10,
        ];
    }
}
