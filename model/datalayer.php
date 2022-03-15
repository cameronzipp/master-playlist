<?php

/*
 * CREATE TABLE user (
 *   user_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 *   email VARCHAR(100),
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

    public function getSongs($limit = null)
    {
        if ($limit === null) {
            return $this->_api;
        }

        return array_slice($this->_api, 0, $limit);
    }

    public function getSongsFromIds(array $songIds)
    {
        return array_filter($this->_api, function($item) use ($songIds) {
            return in_array($item['song']['id'], $songIds);
        });
    }

    public function getSong($song_id)
    {
        $song = false;
        foreach($this->_api as $item) {
            if ($item['song']['id'] === $song_id) {
                $song = $item;
                break;
            }
        }
        return $song;
    }

    public function insertSongToPlaylist($playlist_id, $song_id)
    {
        $sql = "INSERT INTO song (playlist_id, song_id)
                VALUES (:playlist_id, :song_id)";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(
            ':playlist_id'   => $playlist_id,
            ':song_id'   => $song_id
        );

        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return $this->_dbh->lastInsertId();
    }

    public function removeSongFromPlaylist($playlist_id, $song_id)
    {
        $sql = "DELETE FROM song WHERE playlist_id = :playlist_id AND song_id = :song_id";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(
            ':playlist_id'   => $playlist_id,
            ':song_id'   => $song_id
        );

        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * inserts a User object into the database
     * @param User $user the user to insert
     * @return string the user_id of the inserted row
     */
    public function insertUser(User $user): string
    {
        $sql = "INSERT INTO user (email, username, password, admin)
                VALUES (:email, :username, :password, :admin)";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(
            ':email'   => $user->getEmail(),
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
     * inserts a Playlist object into the database
     * @param User $user the user to insert
     * @return string the user_id of the inserted row
     */
    public function insertPlaylist(User $user): string
    {
        $sql = "INSERT INTO playlist (user_id, name, publicity)
                VALUES (:user_id, :name, :publicity)";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(
            ':user_id'   => $user->getId(),
            ':name'      => "My Playlist",
            ':publicity' => Publicity::PUBLIC()
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

    public function getPlaylist($playlist_id)
    {
        $sql = "SELECT * FROM playlist WHERE playlist_id = :playlist_id";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(':playlist_id' => $playlist_id);
        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return $statement->fetch();
    }

    public function getPlaylistFromUserId($user_id)
    {
        $sql = "SELECT * FROM playlist WHERE user_id = :user_id";

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

    public function getSongsFromPlaylistId($playlist_id): array
    {
        $sql = "SELECT song_id FROM `song` WHERE playlist_id = :playlist_id";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(':playlist_id' => $playlist_id);
        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
