<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<script>
var botmanWidget = {
    title: "Mein Testbot",
    introMessage: "Willkommen beim Chatbot des Roten Kreuzes Niederösterreich, wie kann ich Ihnen helfen?",
    aboutText: "Powered By MaStEr05111",
    frameEndpoint: '/site/chatframe',
    chatServer: '/site/hearbot'    
};
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

<head>
    <title>BotMan Widget</title>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">-->
</head>

