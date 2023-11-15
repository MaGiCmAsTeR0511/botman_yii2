<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Problem_table]].
 *
 * @see Problem_table
 */
class Problem_tableQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Problem_table[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Problem_table|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
