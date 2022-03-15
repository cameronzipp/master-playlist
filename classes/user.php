<?php

use Ds\Map;

class User
{
    // fields, properties, data members, instance variables
    private string $_id;
    private string $_email;
    private string $_username;
    private string $_password;
    private Playlist $_playlist;
    private array $_friends;

    function __construct($email, $username, $password)
    {
        $this->_email = $email;
        $this->_username = $username;
        $this->_password = $password;
    }

    function login()
    {
        $_SESSION['logged'] = $this;
        global $dataLayer;
        $this->setPlaylist(Util::convert_playlist_array($dataLayer->getPlaylistFromUserId($this->getId())));
    }
    function register()
    {
        global $dataLayer;
        $this->setId($dataLayer->insertUser($this));
        $playlistId = $dataLayer->insertPlaylist($this);
        $this->setPlaylist(Util::convert_playlist_array($dataLayer->getPlaylist($playlistId)));

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
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }
    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->_username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->_username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
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
    public function getPlaylist(): Playlist
    {
        return $this->_playlist;
    }

    /**
     * @param Playlist $playlist
     */
    public function setPlaylist(Playlist $playlist)
    {
        $this->_playlist = $playlist;
    }

    /**
     * @return array array of friends
     */
    public function getFriends(): array
    {
        return $this->_friends;
    }

    /**
     * @param string $friend_id
     */
    public function addFriend(string $friend_id): void
    {

    }

    /**
     * @param string $friend_id
     */
    public function removeFriend(string $friend_id): void
    {

    }
}
