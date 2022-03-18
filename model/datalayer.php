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
 *   visibility ENUM('public', 'private', 'friends_only')
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


    /**
     * The DataLayer constructor. Instantiates the databas and json file.
     */
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
     * Gets the json array. If a $limit is set, then the array will be truncated to that amount.
     * @param int|null $limit if an int, the length of the array to truncate to; if null, the full array.
     * @return array the json array of songs
     */
    public function getSongs(int $limit = null)
    {
        if ($limit === null) {
            return $this->_api;
        }

        return array_slice($this->_api, 0, $limit);
    }

    /**
     * Gets the songs based on the song id's and returns them in an array
     * @param array $songIds the array of song id's to look up
     * @return array an array of songs
     */
    public function getSongsFromIds(array $songIds)
    {
        return array_filter($this->_api, function($item) use ($songIds) {
            return in_array($item['song']['id'], $songIds);
        });
    }

    /**
     * Gets a song based on it's id
     * @param $song_id the song id to look up
     * @return false|array-key returns false if the song was not found, otherwise returns the song
     */
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

    /**
     * Inserts a song id into a playlist database.
     * @param string $playlist_id the playlist that the song is a part of
     * @param string $song_id the id of the song in the playlist
     * @return string the id of the last inserted column
     */
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

    /**
     * Deletes a song id from a playlist database.
     * @param string $playlist_id the playlist that the song is a part of
     * @param string $song_id the id of the song in the playlist
     */
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
        $sql = "INSERT INTO playlist (user_id, name, visibility)
                VALUES (:user_id, :name, :visibility)";

        $statement = false;
        try {
            $statement = $this->_dbh->prepare($sql);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        $params = array(
            ':user_id'   => $user->getId(),
            ':name'      => "My Playlist",
            ':visibility' => Visibility::PUBLIC()
        );

        try {
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

        return $this->_dbh->lastInsertId();
    }

    /**
     * Gets the user from the database
     * @param string $user_id the id of the user
     * @return array returns the user column from the database
     */
    public function getUser(string $user_id)
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
     * @param string $user_username the user's username
     * @return array|false returns the user in the column, false otherwise
     */
    public function getUserByUsername(string $user_username)
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

    /**
     * Gets the specified playlist
     * @param string $playlist_id the id of the playlist
     * @return array the playlist column from the table
     */
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

    /**
     * Gets the playlist associated with a user id
     * @param string $user_id the id of the user that is attached to the playlist
     * @return array|false returns the playlist column, otherwise false
     */
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

    /**
     * Gets the songs based on the playlist id
     * @param string $playlist_id the playlist id to use to search up all the songs
     * @return array returns all the song id's associated with the playlist id
     */
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
