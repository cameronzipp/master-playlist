<?php

class User
{
    // fields, properties, data members, instance variables
    private string $_id;
    private string $_username;
    private string $_password;
    private Playlist $_playlist;

    function __construct($username, $password)
    {
        $this->_username = $username;
        $this->_password = $password;
    }

    function login()
    {
        $_SESSION['logged'] = $this->getId();
    }

    function logout()
    {
        $_SESSION['logged'] = '';
    }

    function updatePassword($oldPassword, $newPassword)
    {
        // if old password does not equal saved password
        if ($this->_password !== $oldPassword) {
            return false;
        }

        // if saved password equals new password
        if ($this->_password === $newPassword)
        {
            return false;
        }

        // update password
        $this->_password = $newPassword;

        return true;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return Playlist
     */
    public function getPlaylist()
    {
        return $this->_playlist;
    }

    /**
     * @param Playlist $playlist
     */
    public function setPlaylist($playlist)
    {
        $this->_playlist = $playlist;
    }
}
