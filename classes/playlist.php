<?php

/**
 * The Playlist class that's used for holding all the playlist information.
 */
class Playlist
{
    private string $_id;
    private string $_name;
    private string $_creation_date;
    private array $_song_ids;
    private Visibility $_visibility;

    /**
     * The Playlist constructor.
     * @param string $_name the name of the playlist
     * @param Visibility $_visibility the playlist's visibility
     */
    public function __construct(string $_name, Visibility $_visibility)
    {
        $this->_name = $_name;
        $this->_visibility = $_visibility;
    }


    /**
     * Gets the playlist id
     * @return string the playlist id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets the playlist id
     * @param string $id the playlist id
     */
    public function setId(string $id): void
    {
        $this->_id = $id;
    }

    /**
     * Gets the array of song ids
     * @return array the array of song ids
     */
    public function getSongIds(): array
    {
        return $this->_song_ids;
    }

    /**
     * Sets the array of song ids
     * @param array $song_ids the array of song ids
     */
    public function setSongIds(array $song_ids)
    {
        $this->_song_ids = $song_ids;
    }

    /**
     * Adds a song to the song id's array and inserts it into the database.
     * @param string $song_id the id to insert into the playlist and database
     * @return bool returns false if it's already in the array, true otherwise
     */
    public function addSong(string $song_id): bool
    {
        if (in_array($song_id, $this->_song_ids)) {
            return false;
        }

        global $dataLayer;
        $dataLayer->insertSongToPlaylist($this->_id, $song_id);

        array_push($this->_song_ids, $song_id);
        return true;
    }

    /**
     * Removes a song id from the internal array and database
     * @param string $song_id the song id to remove
     * @return bool returns false if there's nothing to remove, true otherwise
     */
    public function removeSong(string $song_id): bool
    {
        if (!in_array($song_id, $this->_song_ids)) {
            return false;
        }

        global $dataLayer;
        $dataLayer->removeSongFromPlaylist($this->_id, $song_id);

        $this->_song_ids = array_diff($this->_song_ids, [$song_id]);
        return true;
    }

    /**
     * Gets the playlist name
     * @return string the playlist name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Gets the creation date
     * @return string the creation date
     */
    public function getCreationDate(): string
    {
        return $this->_creation_date;
    }

    /**
     * Sets the creation date
     * @param string $creation_date the creation date
     */
    public function setCreationDate(string $creation_date)
    {
        $this->_creation_date = $creation_date;
    }

    /**
     * Gets the visibility type of the Playlist
     * @return Visibility visibility type
     */
    public function getVisibility(): Visibility
    {
        return $this->_visibility;
    }
}
