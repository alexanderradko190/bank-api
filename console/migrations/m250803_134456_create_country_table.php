<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country}}`.
 */
class m250803_134456_create_country_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull()->unique(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }
}
