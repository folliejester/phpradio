<?php

// Set the content type header to mp3

header('Content-Type: audio/mpeg');

// Define the directory where the music is stored

$music_dir = 'https://radio.rxo.me/music/';

// Get a list of all the songs in the directory

$songs = glob($music_dir . '*.mp3');

// Shuffle the list of songs

shuffle($songs);

// Loop through each song and stream it to the client

foreach ($songs as $song) {

    // Use ffmpeg to convert the song to a streamable format

    $cmd = "ffmpeg -i '$song' -f mp3 -";

    $descriptors = [

        0 => ['pipe', 'r'],

        1 => ['pipe', 'w'],

        2 => ['pipe', 'w'],

    ];

    $process = proc_open($cmd, $descriptors, $pipes);

    if (is_resource($process)) {

        fpassthru($pipes[1]);

        fclose($pipes[0]);

        fclose($pipes[1]);

        fclose($pipes[2]);

        proc_close($process);

    }

}
?>
