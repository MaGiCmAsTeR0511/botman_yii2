<?php

namespace app\models;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use yii\base\Model;
use yii\db\Exception;

class Problem extends Conversation
{
    public $text;

    public $temp_id;

    public $user_department;
    public $user_team;
    private $departments = ['IT' => ['client', 'web'], 'FINANCE' => ['salary'], 'FACILITY' => ['electricity', 'facility']];
    private $it_keywords = ['client'=> ['meinrechner', 'meincomputer', 'thinclient', 'computer','netzwerk','server', 'switch','lankabel',], 'web' => ['weboberfläche', 'iminternet','intranet','internet','web', 'schnittstelle','homepage','typo3','wordpress','joomla']];
    private $finance_keywords = ['salary' => ['gehalt','steuer','nachzahlung','abrechnung','abrechnungprogramm', 'finanzproblem', 'navisionprogramm', 'navision']];
    private $facility_keywords =['electricity' => ['strom', 'lampe', 'steckdose', 'licht', 'beleuchtung', 'Elektroauto'], 'facility' => ['parkplatz', 'wand', 'boden', 'dreck', 'schmutz', 'reinigung', 'fuhrpark', 'sicherheitsfachkraft']];


    public function welcomeMessage(){
        $this->say('Hallo, ich habe gehört due hast ein Problem? Ich möchte dir dabei helfen dass es an die richtige Stelle weitergegeben wird');
        $this->ask('Könntest du mir bitte das Problem beschreiben?[Ja/Nein]', [
            [
                'pattern' => 'yes|yep|Ja|ja',
                'callback' => function () {
                    $this->describeProblem();
                }
            ],
            [
                'pattern' => 'nah|no|nope|Nein|nein',
                'callback' => function () {
                    $this->say('Dann habe ich dass wohl falsch verstanden');
                    $this->stopsConversation('Wie kann ich dir noch behilflich sein ');
                }
            ]
        ]);
       /*$this->ask('Könntest du mir bitte das Problem beschreiben?[Ja/Nein]', function(Answer $answer){
            if(in_array(mb_strtolower($answer->getText()),['nein','nope', 'ne'])){
                $this->say('Dann habe ich dass wohl falsch verstanden');
                return true;
            }else{
                $this->describeProblem();
            }
        });*/


    }


    public function describeProblem(){
        $this->ask("Dann beschreib es mir bitte, so genau wie möglich ", function(Answer $answer){
            $model = new Problem_table();
            $default = false;
            $model->id = 0;
            $model->text = $answer->getText();
            $model->calculated_team = $this->searchkey($model->text);
            if(empty($model->calculated_team)){
                $default = true;
                $model->calculated_team = 'client';
            }
            $model->calculated_department = $this->getDepartment($model->calculated_team);

            if(!$model->save()){
                $this->say("Es tut mir leid beim Speichern der Antwort ist etwas schiefgegangen....");
            }else {
                $this->temp_id = $model->id;
                if($default){
                    $this->say("Ich konnte dein Problem nicht genau zuordnen deswegen hab ich es der Abteilung ". $model->calculated_department . "zugeordnet");
                }else{
                    $this->say("Laut meiner Überlegung ist dein Problem am besten bei der Abteilung " . $model->calculated_department . ' aufgehoben');
                }

                $this->ask("Habe ich damit recht oder liege ich falsch [Ja -> ich liege richtig/Nein -> ich liege falsch]", [
                        [
                            'pattern' => 'yes|yep|Ja|ja',
                            'callback' =>  function() {
                                $this->properlydescribed();
                            }
                        ],
                        [
                            'pattern' => 'nah|no|nope|Nein|nein',
                            'callback' => function () {
                                $this->notporperlydescribed();
                                }
                        ]
                    ]
                );
            }
        });
    }

    public function properlydescribed(){
        $model = Problem_table::findOne(['id' => $this->temp_id]);
        $model->user_department = $model->calculated_department;
        $model->user_team = $model->calculated_team;
        $model->save();
        $this->say('Vielen Dank für den Test des Chatbots');
    }

    public function notporperlydescribed()
    {
        $this->say("Dann würde ich die bitten mich bei der Korrektur zur unterstützen?");
        $this->ask("Welcher Abteilung  würdest du das Ticket zuordnen? Folgende Abteilungen sind zulässig: IT,FINANCE,FACILITY", function (Answer $answer) {

            if(in_array($answer->getText(),["IT","FINANCE","FACILITY"])){
                $this->user_department = $answer->getText();
                $teams = implode(",",$this->departments[$this->user_department]);
                $this->ask("Danke! Welchem Team würdest du es am ehesten zuordnen? Folgende Teams sind zulässig: $teams", function( Answer $answer2){
                    $teams = $this->departments[$this->user_department];
                    if(in_array($answer2->getText(),$teams)){
                        $model = Problem_table::findOne(['id' => $this->temp_id]);
                        $model->user_department = $this->user_department;
                        $model->user_team = $answer2->getText();
                        $model->save();
                        $this->say('Vielen Dank für den Test des Chatbots und das korrigieren :D');
                    }else{
                       $this->say("Dieses Team gibt es leider nicht versuchen wir es nochmal.....");
                       $this->notporperlydescribed();
                    }
                });
            }else{
                $this->say("Diese Abteilung gibt es leider nicht !!!!");
                $this->notporperlydescribed();
            }


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



    return key($ranking);
    }

    public function run(){
        $this->welcomeMessage();
    }

    private function getDepartment($key){
       foreach ($this->departments as $arraykey => $value){
           if(in_array($key,$value)){
               return $arraykey;
           }
       }
    }

    private function updateModel($department, $team){
        $model = Problem_table::find()->where(['id' => $this->temp_id])->one();
        $model->user_department = $department;
        $model->user_team = $team;
        return $model->save();

    }

}