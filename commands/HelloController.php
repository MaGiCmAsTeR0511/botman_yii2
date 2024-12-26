<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Problem;
use app\models\Problem_table;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{

    private $departments = ['IT' => ['client', 'web'], 'FINANCE' => ['salary'], 'FACILITY' => ['electricity', 'facility']];
    private $it_keywords = ['client' => ['meinrechner', 'meincomputer', 'thinclient', 'computer', 'netzwerk', 'server', 'switch', 'lankabel',], 'web' => ['weboberfläche', 'iminternet', 'intranet', 'internet', 'web', 'schnittstelle', 'homepage', 'typo3', 'wordpress', 'joomla']];
    private $finance_keywords = ['salary' => ['gehalt', 'steuer', 'nachzahlung', 'abrechnung', 'abrechnungprogramm', 'finanzproblem', 'navisionprogramm', 'navision', 'geld']];
    private $facility_keywords = ['electricity' => ['strom', 'lampe', 'steckdose', 'licht', 'beleuchtung', 'Elektroauto'], 'facility' => ['parkplatz', 'wand', 'boden', 'dreck', 'schmutz', 'reinigung', 'fuhrpark', 'sicherheitsfachkraft']];

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }


    public function actionDatenreinknallen()
    {
        $verzeichniss = __DIR__.'/../Storage';
        if (is_dir($verzeichniss)) {
            // öffnen des Verzeichnisses
            if ($handle = opendir($verzeichniss)) {
                // einlesen der Verzeichnisses

                while (($file = readdir($handle)) !== false) {
                    if(!is_dir( $verzeichniss .'/'. $file)) {
                        $zitate = file($verzeichniss . '/' . $file);
                        for ($i = 0; $i < count($zitate); $i++) {
                            if(!empty($zitate[$i])) {
                                if(!Problem_table::find()->where(['text' => $zitate[$i]])->exists()) {
                                    $model = new Problem_table();
                                    $model->id = 0;
                                    $model->text = $zitate[$i];
                                    $model->calculated_team = $this->searchkey($zitate[$i]);
                                    $model->calculated_department = $this->getDepartment($model->calculated_team);
                                    $model->user_department = $model->calculated_department;
                                    $model->user_team = $model->calculated_team;
                                    if (!$model->save()) {
                                        echo '<pre>' . print_r($model->errors, TRUE) . '</pre>';
                                    }
                                }
                            }

                        }
                    }
                }
                closedir($handle);
            }
        }


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

    private function getDepartment($key)
    {
        foreach ($this->departments as $arraykey => $value) {
            if (in_array($key, $value)) {
                return $arraykey;
            }
        }
    }
}
