<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%problem}}".
 *
 * @property int $id
 * @property string $text
 * @property string $calculated_department
 * @property string $calculated_team
 * @property string|null $user_department
 * @property string|null $user_team
 */
class Problem_table extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%problem}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'calculated_department', 'calculated_team'], 'required'],
            [['text'], 'string'],
            [['calculated_department', 'calculated_team', 'user_department', 'user_team'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'calculated_department' => Yii::t('app', 'Calculated Department'),
            'calculated_team' => Yii::t('app', 'Calculated Team'),
            'user_department' => Yii::t('app', 'User Department'),
            'user_team' => Yii::t('app', 'User Team'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return Problem_tableQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Problem_tableQuery(get_called_class());
    }
}
