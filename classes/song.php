<?php

class Song
{
    private string $_id;
    private string $_title;
    private Artist $_artist;
    private string $_duration;
    private string $_album_artwork;
    private string $_release_date;

    /**
     * @param string $_id
     * @param string $_title
     * @param Artist $_artist
     * @param string $_duration
     * @param string $_album_artwork
     * @param string $_release_date
     */
    public function __construct(string $_id, string $_title, Artist $_artist, string $_duration, string $_album_artwork, string $_release_date)
    {
        $this->_id = $_id;
        $this->_title = $_title;
        $this->_artist = $_artist;
        $this->_duration = $_duration;
        $this->_album_artwork = $_album_artwork;
        $this->_release_date = $_release_date;
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
    public function getAlbumArtwork(): string
    {
        return $this->_album_artwork;
    }

    /**
     * @param string $album_artwork
     */
    public function setAlbumArtwork(string $album_artwork): void
    {
        $this->_album_artwork = $album_artwork;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->_release_date;
    }

    /**
     * @param string $release_date
     */
    public function setReleaseDate(string $release_date): void
    {
        $this->_release_date = $release_date;
    }
}
