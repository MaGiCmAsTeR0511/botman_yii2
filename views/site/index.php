<?php

/* @var $this yii\web\View */

$this->title = 'Test Ticket-Chatbot';
?>
<script>
var botmanWidget = {
    title: "Test Ticket-Chatbot",
    introMessage: "Willkommen beim Ticket-Chatbot!",
    aboutText: "Powered By Kurt Hohenauer",
    frameEndpoint: '/site/chatframe',
    chatServer: '/chatbot/hearbot'    
};
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

<head>
    <title>BotMan Widget</title>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">-->
</head>

