<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bank}}`.
 */
class m250803_134715_create_bank_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%bank}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text()->null(),
            'country_id' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(0),
        ]);
        $this->addForeignKey('fk_bank_country', '{{%bank}}', 'country_id', '{{%country}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_bank_country', '{{%bank}}');
        $this->dropTable('{{%bank}}');
    }
}
