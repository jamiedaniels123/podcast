<?php
class YoutubeSubjectPlaylist extends AppModel {

    var $name = 'YoutubeSubjectPlaylist';
    var $useTable = 'youtube_subject_playlists';
    var $validate = array();

    var $hasAndBelongsToMany = array(

        'PodcastItems' => array(
            'className' => 'PodcastItem',
            'joinTable' => 'podcasts_subject_playlists',
            'foreignKey' => 'youtube_subject_playlist_id',
            'associationForeignKey' => 'podcast_id',
            'unique' => true
        )
    );
}
