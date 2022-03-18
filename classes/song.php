<?php

/**
 * UNUSED CLASS
 *
 * THIS CLASS IS CURRENTLY NOT BEING USED. IT MIGHT BE USED IN THE FUTURE.
 */
class Song
{
    private string $_id;
    private string $_title;
    private string $_artist;
    private string $_genres;
    private string $_duration;
    private string $_release_year;

    /**
     * The song constructor
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
     * Gets the song title
     * @return string the song title
     */
    public function getTitle(): string
    {
        return $this->_title;
    }

    /**
     * Sets the song title
     * @param string $title the song title
     */
    public function setTitle(string $title): void
    {
        $this->_title = $title;
    }

    /**
     * Gets the artist's name
     * @return string the artist's name
     */
    public function getArtist(): string
    {
        return $this->_artist;
    }

    /**
     * Sets the artist's name
     * @param string $artist
     */
    public function setArtist(string $artist): void
    {
        $this->_artist = $artist;
    }

    /**
     * Gets the duration of the song
     * @return string the song duration
     */
    public function getDuration(): string
    {
        return $this->_duration;
    }

    /**
     * Sets the song duration
     * @param string $duration the song duration
     */
    public function setDuration(string $duration): void
    {
        $this->_duration = $duration;
    }

    /**
     * Gets the song's release year
     * @return string the song's release year
     */
    public function getReleaseYear(): string
    {
        return $this->_release_year;
    }

    /**
     * Sets the song's release year
     * @param string $release_year the song's release year
     */
    public function setReleaseYear(string $release_year): void
    {
        $this->_release_year = $release_year;
    }
}
