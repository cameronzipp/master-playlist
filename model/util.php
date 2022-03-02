<?php

class Util
{
    static function getAccount($username): ?User
    {
        foreach (DataLayer::getUsers() as $saved_user) {
            if ($username === $saved_user->getUsername()) {
                return $saved_user;
            }
        }
        foreach (DataLayer::getAdmins() as $saved_admin) {
            if ($username === $saved_admin->getUsername()) {
                return $saved_admin;
            }
        }

        return null;
    }
}
