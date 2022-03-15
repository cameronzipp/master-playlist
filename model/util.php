<?php

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

    static function convert_playlist_array(array $playlistArray): Playlist
    {
        $playlist = new Playlist($playlistArray['name'], Publicity::from($playlistArray['publicity']));
        $playlist->setId($playlistArray['playlist_id']);
        $playlist->setCreationDate($playlistArray['creation_date']);
        global $dataLayer;
        $songs = $dataLayer->getSongsFromPlaylistId($playlist->getId());

        $songs = array_map(function ($item) {return $item['song_id'];}, $songs);

        $playlist->setSongIds($songs);

        return $playlist;
    }
}
