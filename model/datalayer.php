<?php

class DataLayer
{
    static function getAdmins(): array
    {
        return array(new AdminUser("admin", "p@ssw0rd"));
    }

    static function getUsers(): array
    {
        return array(new User("user", "p@ssw0rd"));
    }
}
