<?php

    function getPassword($username)
    {
        // { ["username"]=> string ["password"]=> string }
        foreach (getUsers() as $saved_user) {
            if ($username === $saved_user['username']) {
                return $saved_user['password'];
            }
        }
        foreach (getAdmins() as $saved_admin) {
            if ($username === $saved_admin['username']) {
                return $saved_admin['password'];
            }
        }
        return 0;
    }