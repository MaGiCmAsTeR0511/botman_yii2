<?php

namespace app\models;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use yii\base\Model;

class Problem extends Conversation
{

    public $text;

    private $it_keywords = ['client'=> ['meinrechner', 'meincomputer', 'thinclient', 'computer'], 'web' => ['weboberfläche', 'iminternet','intranet','internet','web']];
    private $finance_keywords = ['salary' => ['gehalt','steuer','nachzahlung','abrechnung'], 'navision' =>['abrechnung', 'finanzproblem', 'navisionprogramm']];
    private $facility_keywords =['electricity' => ['strom', 'lampe', 'steckdose', 'licht'], 'facility' => ['parkplatz', 'wand', 'boden', 'dreck', 'schmutz']];


    public function welcomeMessage(){
        $this->say('Hallo, ich habe gehört due hast ein Problem? Ich möchte dir dabei helfen dass es an die richtige Stelle weitergegeben wird');
        $this->ask('Könntest du mir bitte das Problem beschreiben?[Ja/Nein]', function(Answer $answer){
            if(in_array(mb_strtolower($answer->getText()),['nein','nope', 'ne'])){
                $this->say('Dann habe ich dass wohl falsch verstanden');
                return true;
            }else{
                $this->describeProblem();
            }
        });


    }


    public function describeProblem(){
        $this->ask("Dann beschreib es mir bitte, so genau wie möglich ", function(Answer $answer){
            $this->say("Laut meiner Überlegung ist dein Problem am besten bei ".$this->searchkey($answer).'aufgehoben');

        });


    }
    private function searchkey($text)
    {
        $text = str_ireplace(array('\'', '"',
            ',', ';', '<', '>'), ' ', mb_strtolower($text));
        $ranking = array(
            'client' => 0,
            'web' => 0,
            'salary' => 0,
            'navision' => 0,
            'electricity' => 0,
            'facility' => 0
        );
        $split = explode(' ', $text);
        foreach ($split as $sp) {
            if (in_array($sp, $this->it_keywords['client'])) {
                $ranking['client']++;
            }
            if (in_array($sp, $this->it_keywords['web'])) {
                $ranking['web']++;
            }
            if (in_array($sp, $this->finance_keywords['salary'])) {
                $ranking['salary']++;
            }
            if (in_array($sp, $this->finance_keywords['navision'])) {
                $ranking['navision']++;
            }
            if (in_array($sp, $this->facility_keywords['electricity'])) {
                $ranking['electricity']++;
            }
            if (in_array($sp, $this->facility_keywords['facility'])) {
                $ranking['facility']++;
            }
        }
        // Sortiere das Ranking absteigend nach den Werten
        $ranking = array_filter($ranking, function ($value) {
            return $value !== 0;
        });
        arsort($ranking);
        echo '<pre>'.print_r($ranking,TRUE).'</pre>';



    return reset($ranking);
    }

    public function run(){
        $this->welcomeMessage();
    }

}