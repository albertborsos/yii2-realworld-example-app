<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorite}}`.
 */
class m190508_103658_create_favorite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorite}}', [
            'user_id' => $this->integer(),
            'article_id' => $this->integer(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_favorite', '{{%favorite}}', ['article_id', 'user_id']);

        $this->addForeignKey('fk_favorite_user_id', '{{%favorite}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_favorite_article_id', '{{%favorite}}', 'article_id', '{{%article}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%favorite}}');
    }
}
