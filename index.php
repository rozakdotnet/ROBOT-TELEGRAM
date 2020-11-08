<?php

require_once '/var/www/dev.rozak.net/robot/inc/robot.php'; //SESUAIKAN

$robot = new robot('API', 'userbot'); //SESUAIKAN

// Simple
$robot->cmd('*', 'Hi, human! I am a bot.');

// Simple echo
$robot->cmd('echo|say', function ($text) {
    if ($text == '') {
        $text = 'Command usage: /echo [text] or /say [text]';
    }

    return Bot::sendMessage($text);
});

// Whoami
$robot->cmd('whoami', function () {
    // Get message properties
    $message = Bot::message();
    $name = $message['from']['first_name'];
    $userId = $message['from']['id'];
    $text = 'You are <b>'.$name.'</b> and your ID is <code>'.$userId.'</code>';
    $options = [
        'parse_mode' => 'html',
        'reply' => true,
    ];

    return Bot::sendMessage($text, $options);
});

// split
$robot->cmd('split', function ($one, $two, $three) {
    $text = "First word: $one\n";
    $text .= "Second word: $two\n";
    $text .= "Third word: $three";

    return Bot::sendMessage($text);
});

// Send document
$robot->cmd('/upload', function () {
    $file = './composer.json';

    return Bot::sendDocument($file);
});

// inline keyboard
$robot->cmd('inline', function () {
    $keyboard[] = [
        ['text' => 'BLOG', 'url' => 'https://go.rozak.net/blog'],
        ['text' => 'Telegram', 'url' => 'https://telegram.me/rozakdotnet'],
    ];
    $options = [
        'reply_markup' => ['inline_keyboard' => $keyboard],
    ];

    return Bot::sendMessage('Inline keyboard', $options);
});

// regex
$robot->regex('/\/number ([0-9]+)/i', function ($matches) {
    return Bot::sendMessage($matches[1]);
});

// Inline
$robot->on('inline', function ($text) {
    $results[] = [
        'type' => 'article',
        'id' => 'unique_id1',
        'title' => $text,
        'message_text' => 'Lorem ipsum dolor sit amet',
    ];
    $options = [
        'cache_time' => 3600,
    ];

    return Bot::answerInlineQuery($results, $options);
});

$robot->run();
