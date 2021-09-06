<?php

namespace app\controllers;

use Yii;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use yii\rest\Controller;

class ChatbotController extends Controller
{

    public function actionHearbot(){
        $config = [
            // Your driver-specific configuration
            // "telegram" => [
            //    "token" => "TOKEN"
            // ]
        ];
        
        // Load the driver(s) you want to use
        DriverManager::loadDriver(WebDriver::class);
        
        // Create an instance
        $botman = BotManFactory::create($config);
        
        // Give the bot something to listen for.
        $botman->hears('hallo', function ($bot) {
            $bot->reply('Hallo');
        });

        $botman->fallback(function($bot) {
            $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
        });
        
        // Start listening
        $botman->listen();
        die();
    }
}
