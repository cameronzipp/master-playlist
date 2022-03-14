<?php

class Song
{
    private string $_id;
    private string $_title;
    private string $_artist;
    private string $_genres;
    private string $_duration;
    private string $_release_year;

    /**
     * @param string $_id
     * @param string $_title
     * @param string $_duration
     * @param string $_release_year
     */
    public function __construct(string $_id, string $_title, string $_artist, string $_genres, string $_duration, string $_release_year)
    {
        $this->_id = $_id;
        $this->_title = $_title;
        $this->_artist = $_artist;
        $this->_genres = $_genres;
        $this->_duration = $_duration;
        $this->_release_year = $_release_year;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->_title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->_title = $title;
    }

    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return $this->_artist;
    }

    /**
     * @param Artist $artist
     */
    public function setArtist(Artist $artist): void
    {
        $this->_artist = $artist;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->_duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration(string $duration): void
    {
        $this->_duration = $duration;
    }

    /**
     * @return string
     */
    public function getReleaseYear(): string
    {
        return $this->_release_year;
    }

    /**
     * @param string $release_date
     */
    public function setReleaseYear(string $release_date): void
    {
        $this->_release_year = $release_date;
    }
}
