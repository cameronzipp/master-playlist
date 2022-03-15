<?php

class Playlist
{
    private string $_id;
    private string $_name;
    private string $_creation_date;
    private array $_song_ids;
    private Publicity $_publicity;

    /**
     * @param string $_name
     * @param Publicity $_publicity
     */
    public function __construct(string $_name, Publicity $_publicity)
    {
        $this->_name = $_name;
        $this->_publicity = $_publicity;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->_id = $id;
    }

    /**
     * @return array
     */
    public function getSongIds(): array
    {
        return $this->_song_ids;
    }

    public function setSongIds(array $song_ids)
    {
        $this->_song_ids = $song_ids;
    }

    public function addSong($song_id)
    {
        if (in_array($song_id, $this->_song_ids)) {
            return false;
        }

        global $dataLayer;
        $dataLayer->insertSongToPlaylist($this->_id, $song_id);

        array_push($this->_song_ids, $song_id);
    }

    public function removeSong($song_id)
    {
        if (!in_array($song_id, $this->_song_ids)) {
            return false;
        }

        global $dataLayer;
        $dataLayer->removeSongFromPlaylist($this->_id, $song_id);

        $this->_song_ids = array_diff($this->_song_ids, [$song_id]);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->_creation_date;
    }

    public function setCreationDate($creation_date)
    {
        $this->_creation_date = $creation_date;
    }

    /**
     * @return Publicity publicity type
     */
    public function getPublicity(): Publicity
    {
        return $this->_publicity;
    }
}
