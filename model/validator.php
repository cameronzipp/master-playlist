<?php

class Validator
{
    /**
     * Validates usernames
     * @param string $username
     * @return bool
     */
    static function validUsername($username)
    {
        return !empty($username) && preg_match("/^[^\d][\w\d-]{3,16}$/", $username) === 1;
    }

    /**
     * Validates passwords
     * @param $password
     * @return bool
     */
    static function validPassword($password)
    {
        return !empty($password) && preg_match("/^[\w\d!@#$%^&*]{10,64}$/", $password) === 1;
    }
}
