<?php

/**
 * Stores all the utility methods used throughout the application.
 */
class Util
{
    /**
     * Converts the given array from the database into a User|AdminUser object
     * @param array $userArray the array given from the database
     * @return User|AdminUser the converted user object
     */
    static function convert_user_array(array $userArray)
    {
        $user = null;

        if ($userArray['admin']) {
            $user = new AdminUser($userArray['email'], $userArray['username'], $userArray['password']);
        } else {
            $user = new User($userArray['email'], $userArray['username'], $userArray['password']);
        }
        $user->setId($userArray['user_id']);

        return $user;
    }

    /**
     * Converts an array from the playlist database into a Playlist class
     * @param array $playlistArray the array to convert into a Playlist
     * @return Playlist the playlist
     */
    static function convert_playlist_array(array $playlistArray): Playlist
    {
        $playlist = new Playlist($playlistArray['name'], Visibility::from($playlistArray['visibility']));
        $playlist->setId($playlistArray['playlist_id']);
        $playlist->setCreationDate($playlistArray['creation_date']);
        global $dataLayer;
        $songs = $dataLayer->getSongsFromPlaylistId($playlist->getId());

        $songs = array_map(function ($item) {return $item['song_id'];}, $songs);

        $playlist->setSongIds($songs);

        return $playlist;
    }

    /**
     * Creates a basic playlist used for the default playlist and the song library
     * @param string $name the playlist name
     * @param int|null $songLimit if an int, the amount of songs to return. if null, returns all the songs
     * @return Playlist the playlist
     */
    static function create_playlist(string $name, int $songLimit = null): Playlist
    {
        global $dataLayer;
        $playlist = new Playlist($name, Visibility::PUBLIC());
        $songs = array_map(function ($item) {return $item['song']['id'];}, $dataLayer->getSongs($songLimit));
        $playlist->setSongIds($songs);
        return $playlist;
    }

    /**
     * Creats a Json Object out of the songs array
     * @param array $songs the songs to use for creating the json object
     * @param Base $f3 the base to use to get the hive data
     * @return string Stringified Json Object
     */
    static function createJsonObject(array $songs, Base $f3): string
    {
        $object = array("data"=>array());
        foreach($songs as $item)
        {
            if (!empty($_SESSION['logged']) && !in_array($item['song']['id'], $_SESSION['logged']->getPlaylist()->getSongIds())) {
                $songToggle = "<button class=\"btn btn-link apiButton\" data-path=\"" . $f3->get('BASE') . "/api/song/add/" . $item['song']['id'] . "\">Add</button>";
            } else {
                $songToggle = "<button class=\"btn btn-link apiButton\" data-path=\"" . $f3->get('BASE') . "/api/song/remove/" . $item['song']['id'] . "\">Remove</button>";
            }
            $temp = array(
                $songToggle,
                $item['song']['title'],
                $item['artist']['name'],
                $item['artist']['terms'],
                "" . number_format($item['song']['duration'] / 60, 2) . " mins",
                $item['song']['year'] == 0 ? "Unknown" : $item['song']['year']
            );
            array_push($object["data"], $temp);
        }
        return json_encode($object);
    }
}
