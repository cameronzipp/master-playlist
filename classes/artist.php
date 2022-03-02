<?php

class Artist
{
    private string $_id;
    private string  $_name;
    private array $_songs;
    private array $_terms;

    /**
     * @param string $_id
     * @param string $_name
     * @param Song[] $_songs
     * @param array $_terms
     */
    public function __construct(string $_id, string $_name, array $_songs, array $_terms)
    {
        $this->_id = $_id;
        $this->_name = $_name;
        $this->_songs = $_songs;
        $this->_terms = $_terms;
    }


}
