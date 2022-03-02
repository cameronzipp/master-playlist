<?php

class Playlist
{
    private string $_id;
    private string $_name;
    private string $_creation_date;
    private $_favorites;
    private Publicity $_publicity;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
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
     * @return mixed
     */
    public function getFavorites()
    {
        return $this->_favorites;
    }

    /**
     * @return Publicity
     */
    public function getPublicity()
    {
        return $this->_publicity;
    }
}
