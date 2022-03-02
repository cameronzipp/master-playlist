<?php

class Util
{
    static function getPassword($username)
    {
        // { ["username"]=> string ["password"]=> string }
        foreach (DataLayer::getUsers() as $saved_user) {
            if ($username === $saved_user['username']) {
                return $saved_user['password'];
            }
        }
        foreach (DataLayer::getAdmins() as $saved_admin) {
            if ($username === $saved_admin['username']) {
                return $saved_admin['password'];
            }
        }
        return 0;
    }
}
