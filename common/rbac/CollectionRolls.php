<?php

declare(strict_types=1);

namespace app\common\rbac;

class CollectionRolls
{
    public const ROLE_ROOT = 'admin';
    public const ROLE_USER = 'user';

    /**
     * @return string[]
     */
    public static function getListRole(): array
    {
        return [
            self::ROLE_ROOT => 'Администратор',
            self::ROLE_USER => 'Пользователь',
        ];
    }

    /**
     * @param string $role
     * @return string
     */
    public static function getRoleName(string $role): string
    {
        return self::getListRole()[$role];
    }
}
