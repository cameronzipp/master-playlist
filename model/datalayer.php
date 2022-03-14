<?php

/*
 * CREATE TABLE user (
 *   user_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 *   username VARCHAR(50),
 *   password VARCHAR(50),
 *   admin TINYINT(1)
 * );
 *
 * CREATE TABLE friends (
 *     user_id INT(5),
 *   friend_id INT(5)
 * );
 *
 * CREATE TABLE playlist (
 *     playlist_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 *   user_id INT(5),
 *   name VARCHAR(50),
 *   publicity ENUM('public', 'private', 'friends_only')
 * );
 *
 * CREATE TABLE songs (
 *     playlist_id INT(5),
 *   song_id VARCHAR(5)
 * );
 */

// Require the database credentials
require_once $_SERVER['DOCUMENT_ROOT'] . '/../pdo-team-config.php';

/**
 * DataLayer class accesses data needed for the master playlist app
 */
class DataLayer
{
    // database connection object
    private PDO $_dbh;
    private array $_api;

    public function __construct()
    {
        try {
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception) {
            die("Error connecting to DB " . $exception->getMessage());
        }

        $music_json = file_get_contents('music.json');
        $this->_api = json_decode($music_json, true);
    }

    /**
     * inserts a User object into the database
     * @param User $user the user to insert
     * @return string the user_id of the inserted row
     */
    public function insertUser(User $user): string
    {
        $sql = "INSERT INTO user (username, password, admin)
                VALUES (:username, :password, :admin)";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(
            ':username'   => $user->getUsername(),
            ':password'   => $user->getPassword(),
            ':admin'      => $user instanceof AdminUser ? 1 : 0
        );

        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return $this->_dbh->lastInsertId();
    }

    /**
     * Gets the last saved user's Id.
     * @return false|int returns the last saved user id, returns false if it can't
     */
    public function getLastUserId()
    {
        $sql = "SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetch();

        return $result ? intval($result["user_id"]) : false;
    }

    /**
     * grabs the user
     * @param int|string $user_id
     * @return array|false
     */
    public function getUser($user_id)
    {
        $sql = "SELECT * FROM user WHERE user_id = :user_id";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(':user_id' => $user_id);
        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return $statement->fetch();
    }


    /**
     * grabs the user based on the user's username
     * @param string $user_username
     * @return array|false
     */
    public function getUserByUsername($user_username)
    {
        $sql = "SELECT * FROM user WHERE username = :username";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(':username' => $user_username);
        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return $statement->fetch();
    }
}
