<?php

namespace app\controllers;

use app\models\Problem;
use BotMan\BotMan\Cache\CodeIgniterCache;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Cache\Psr6Cache;
use idk\yii2\botman\Cache;
use Yii;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use yii\caching\ApcCache;
use yii\caching\FileCache;
use yii\caching\MemCache;
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
        $botman = BotManFactory::create($config, new Cache());
        
        // Give the bot something to listen for.
        $botman->hears('.*Problem.*', function ($bot) {
            $bot->startConversation(new Problem());
        });

        $botman->hears('.*Hallo.*', function ($bot) {
            $bot->reply('Hallo du :D');
        });

        $botman->fallback(function($bot) {
            $bot->reply('Entschuldigung ich habe dich nicht verstanden. Kannst du es nochmal wiederholen??');
        });


        /*$botman->fallback(function($bot) {
            $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
        });*/

        $botman->hears('Ticket Schließen ([0-9]+)',function($bot,$number){
                    $bot->reply('das Ticket#'.$number.' wurde geschlossen');
        });
         
        // Start listening
        $botman->listen();

    }
}
