<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%task}}`
 */
class m200816_172918_create_file_table extends Migration
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
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(128)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-file-user_id}}',
            '{{%file}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-file-user_id}}',
            '{{%file}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-file-task_id}}',
            '{{%file}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-file-task_id}}',
            '{{%file}}',
            'task_id',
            '{{%task}}',
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
            '{{%fk-file-user_id}}',
            '{{%file}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-file-user_id}}',
            '{{%file}}'
        );

        // drops foreign key for table `{{%task}}`
        $this->dropForeignKey(
            '{{%fk-file-task_id}}',
            '{{%file}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-file-task_id}}',
            '{{%file}}'
        );

        $this->dropTable('{{%file}}');
    }
}
