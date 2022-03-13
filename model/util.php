<?php

class Util
{
    /**
     * Converts the given array from the database into a User|AdminUser object
     * @param array $userArray the array given from the database
     * @return User|AdminUser the converted user object
     */
    static function convert_user_array(array $userArray)
    {
        $user = null;

        if ($userArray['admin']) {
            $user = new AdminUser($userArray['username'], $userArray['password']);
        } else {
            $user = new User($userArray['username'], $userArray['password']);
        }
        $user->setId($userArray['user_id']);

        return $user;
    }
}
