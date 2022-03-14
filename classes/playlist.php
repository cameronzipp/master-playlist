<?php

class Playlist
{
    private string $_id;
    private string $_name;
    private string $_creation_date;
    private array $_song_ids;
    private Publicity $_publicity;

    public function __construct(array $song_ids)
    {
        $this->_song_ids = $song_ids;
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

    /**
     * @return Publicity publicity type
     */
    public function getPublicity()
    {
        return $this->_publicity;
    }
}
