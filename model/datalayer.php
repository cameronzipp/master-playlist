<?php

class DataLayer
{
    static function getAdmins(): array
    {
        return array(
            array('username'=>'admin', 'password'=>'p@ssw0rd')
        );
    }

    static function getUsers(): array
    {
        return array(
            array('username'=>'user', 'password'=>'p@ssw0rd')
        );
    }
}
