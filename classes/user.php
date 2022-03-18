<?php

/**
 * The User class that's used to hold all the user's information.
 */
class User
{
    // fields, properties, data members, instance variables
    private string $_id;
    private string $_email;
    private string $_username;
    private string $_password;
    private Playlist $_playlist;
    private array $_friends;

    /**
     * The constructor for the user
     * @param string $email the user's email
     * @param string $username the user's username
     * @param string $password the user's password
     */
    function __construct(string $email, string $username, string $password)
    {
        $this->_email = $email;
        $this->_username = $username;
        $this->_password = $password;
    }

    /**
     * Used to log the user into the application.
     */
    function login()
    {
        $_SESSION['logged'] = $this;
        global $dataLayer;
        $this->setPlaylist(Util::convert_playlist_array($dataLayer->getPlaylistFromUserId($this->getId())));
    }

    /**
     * Used to Register the user into the application.
     */
    function register()
    {
        global $dataLayer;
        $this->setId($dataLayer->insertUser($this));
        $playlistId = $dataLayer->insertPlaylist($this);
        $this->setPlaylist(Util::convert_playlist_array($dataLayer->getPlaylist($playlistId)));

        // login
        $this->login();
    }

    /**
     * Used to log the user out of the application.
     */
    function logout()
    {
        session_destroy();
    }

    /**
     * Updates the password that the user has
     * @param string $oldPassword the old password to change from
     * @param string $newPassword the new password to change to
     * @return bool true if successful, false otherwise
     */
    function updatePassword(string $oldPassword, string $newPassword)
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
     * Gets the user's id
     * @return string the user's id
     */
    public function getId(): string
    {
        return $this->_id;
    }

    /**
     * Sets the user's id
     * @param string $id the user's id
     */
    public function setId(string $id)
    {
        $this->_id = $id;
    }

    /**
     * Get's the user's email
     * @return string the user's email
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * Sets the user's email
     * @param string $email the user's email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }
    /**
     * Gets the user's username
     * @return string the user's username
     */
    public function getUsername(): string
    {
        return $this->_username;
    }

    /**
     * Sets the user's username
     * @param string $username the user's username
     */
    public function setUsername(string $username)
    {
        $this->_username = $username;
    }

    /**
     * Gets the user's password
     * @return string the user's password
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * Sets the user's password
     * @param string $password the user's password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * Gets the user's playlist
     * @return Playlist the user's playlist
     */
    public function getPlaylist(): Playlist
    {
        return $this->_playlist;
    }

    /**
     * Sets the user's playlist
     * @param Playlist $playlist the user's playlist
     */
    public function setPlaylist(Playlist $playlist)
    {
        $this->_playlist = $playlist;
    }

    /**
     * Gets the array of user id's that are this user's friends
     * @return array array of user id's
     */
    public function getFriends(): array
    {
        return $this->_friends;
    }

    /**
     * Adds a user id into this user's friends array
     * @param string $friend_id the user id to add to the friends array
     * @return bool true if successful, false if it's already in the array
     */
    public function addFriend(string $friend_id): bool
    {
        if (in_array($friend_id, $this->_friends)) {
            return false;
        }

//        global $dataLayer;
//        $dataLayer->insertFriendIntoUser($this->_id, $friend_id);

        array_push($this->_friends, $friend_id);
        return true;
    }

    /**
     * Removes a user id out of this user's friends array
     * @param string $friend_id the user id to remove from the array
     * @return bool true if successful, false if it's not in the array already
     */
    public function removeFriend(string $friend_id): bool
    {
        if (!in_array($friend_id, $this->_friends)) {
            return false;
        }

//        global $dataLayer;
//        $dataLayer->removeFriendFromUser($this->_id, $friend_id);

        $this->_friends = array_diff($this->_friends, [$friend_id]);
        return true;
    }
}
