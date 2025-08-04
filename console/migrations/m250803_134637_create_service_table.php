<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service}}`.
 */
class m250803_134637_create_service_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull()->unique(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%service}}');
    }
}
