<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m250803_134551_create_city_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'country_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_city_country', '{{%city}}', 'country_id', '{{%country}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_city_country', '{{%city}}');
        $this->dropTable('{{%city}}');
    }
}
