<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190507_101155_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->unique(),
            'email' => $this->string(),
            'password' => $this->string(),
            'bio' => $this->text(),
            'image' => $this->string(),
            'token' => $this->string(32),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
