<?php

/**
 * Stores all the validation methods used throughout the application.
 */
class Validator
{

    /**
     * Validates whether the account exists. Returns true if it does, false if it doesn't
     * @param string $username
     * @return bool true if account exists, false if it does not
     */
    static function accountExists(string $username): bool
    {
        global $dataLayer;
        return !($dataLayer->getUserByUsername($username) === false);
    }

    /**
     * Validates usernames
     * @param string $username
     * @return bool true if valid, false otherwise
     */
    static function validUsername($username)
    {
        // is not empty, and
        // does not start with a number or whitespace, and is
        // made up of more than 3 but less than 16 letters, numbers, and dashes
        return !empty($username) && preg_match("/^[^\d\W][\w\d-]{2,16}$/", $username) === 1;
    }

    /**
     * Validates passwords
     * @param string $password
     * @return bool true if valid, false otherwise
     */
    static function validPassword($password)
    {
        // is not empty, and
        // allows the use of letters, numbers, and specific symbols
        // no less than 10 characters, no more than 64 characters
        return !empty($password) && preg_match("/^[\w\d!@#$%^&*]{10,64}$/", $password) === 1;
    }

    /**
     * Validates a users email
     * @param string $email
     * @return bool true if valid, false otherwise
     */
    static function validEmail($email): bool
    {
        //is not empty
        //includes the @ sign and checks if there is a duplicate
        if (preg_match("/^[^\s@]+@[^\s@]+$/", $email) === 1 && strlen($email) > 6 && strlen($email) < 100) {
            return true;
        }
        return false;
    }
}
