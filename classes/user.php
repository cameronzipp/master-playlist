<?php

use Ds\Map;

class User
{
    // fields, properties, data members, instance variables
    private string $_id;
    private string $_username;
    private string $_password;
    private Playlist $_playlist;
    private Map $_friends;

    function __construct($username, $password, $playlist = null, $friends = null)
    {
        $this->_username = $username;
        $this->_password = $password;
        $this->_playlist = $playlist == null ? new Playlist() : $playlist;
        $this->_friends = $friends == null ? new Map() : $friends;
    }

    function login()
    {
        $_SESSION['logged'] = $this;
    }
    function register()
    {
        // add user to database
        $users = DataLayer::getUsers();
        array_push($users, $this);

        // login
        $this->login();
    }
    function logout()
    {
        session_destroy();
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

    /**
     * @return User[] array of friends
     */
    public function getFriends(): array
    {
        return $this->_friends;
    }

    /**
     * @param User $friend
     */
    public function addFriend(User $friend): void
    {
        $this->_friends->put($friend->getId(), $friend);
    }

    /**
     * @param string $friend_id
     */
    public function removeFriend(string $friend_id): void
    {
        if ($this->_friends->hasKey($friend_id)) {
            $this->_friends->remove($friend_id);
        }
    }
}
