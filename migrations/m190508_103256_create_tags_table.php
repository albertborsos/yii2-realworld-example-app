<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags}}`.
 */
class m190508_103256_create_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable('{{%article_tag}}', [
            'article_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'created_at' => $this->bigInteger(),
            'created_by' => $this->integer(),
            'updated_at' => $this->bigInteger(),
            'updated_by' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_article_tag', '{{%article_tag}}', ['article_id', 'tag_id']);

        $this->addForeignKey('fk_article_tag_article_id', '{{%article_tag}}', 'article_id', '{{%article}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_article_tag_tag_id', '{{%article_tag}}', 'tag_id', '{{%tag}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article_tag}}');
        $this->dropTable('{{%tag}}');
    }
}
