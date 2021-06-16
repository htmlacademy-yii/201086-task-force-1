<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_categories}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%categories}}`
 */
class m200818_101855_create_users_categories_table extends Migration
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
        $this->createTable('{{%users_categories}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'status' => $this->integer(2)->defaultValue(0)
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-users_categories-user_id}}',
            '{{%users_categories}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-users_categories-user_id}}',
            '{{%users_categories}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-users_categories-category_id}}',
            '{{%users_categories}}',
            'category_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-users_categories-category_id}}',
            '{{%users_categories}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-users_categories-user_id}}',
            '{{%users_categories}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-users_categories-user_id}}',
            '{{%users_categories}}'
        );

        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-users_categories-category_id}}',
            '{{%users_categories}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-users_categories-category_id}}',
            '{{%users_categories}}'
        );

        $this->dropTable('{{%users_categories}}');
    }
}
