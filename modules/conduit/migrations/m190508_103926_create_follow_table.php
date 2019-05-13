<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%follow}}`.
 */
class m190508_103926_create_follow_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%follow}}', [
            'follower_id' => $this->integer(),
            'followed_id' => $this->integer(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_follow', '{{%follow}}', ['follower_id', 'followed_id']);

        $this->addForeignKey('fk_follow_follower_id', '{{%follow}}', 'follower_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_follow_followed_id', '{{%follow}}', 'followed_id', '{{%user}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%follow}}');
    }
}
