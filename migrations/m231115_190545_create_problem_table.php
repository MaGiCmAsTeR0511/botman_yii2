<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%problem}}`.
 */
class m231115_190545_create_problem_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%problem}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
        'calculated_department' => $this->char(11)->notNull(),
            'calculated_team' => $this->char(11)->notNull(),
            'user_department' => $this->char(11),
            'user_team' => $this->char(11)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%problem}}');
    }
}
