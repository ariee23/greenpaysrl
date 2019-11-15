<?php

$apiToken = "975599523:AAEhdrbDLmLaRXahlCoqiJAoQdp8bRPoqWo";

$data = [
    'chat_id' => '902425783',
    'text' => 'gay'
];

$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
// Do what you want with result

?>
