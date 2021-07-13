<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m200816_172651_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128)->notNull()->unique(),
            'title_en' => $this->string(128)->notNull(),
        ], $tableOptions);

        $this->batchInsert('categories', ['title', 'title_en'], [
            ['Курьерские услуги', 'translation'],
            ['Уборка', 'clean'],
            ['Переезды', 'cargo'],
          ['Компьютерная помощь', 'neo'],
          ['Ремонт квартирный', 'flat'],
          ['Ремонт техники', 'repair'],
          ['Красота', 'beauty'],
          ['Фото', 'photo'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
