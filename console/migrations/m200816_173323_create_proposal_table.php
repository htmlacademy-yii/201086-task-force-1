<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proposal}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%task}}`
 * - `{{%user}}`
 */
class m200816_173323_create_proposal_table extends Migration
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
        $this->createTable('{{%proposal}}', [
            'id' => $this->primaryKey(),
            'comment' => $this->string(128)->notNull(),
            'task_id' => $this->integer()->notNull(),
            'budget' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-proposal-task_id}}',
            '{{%proposal}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-proposal-task_id}}',
            '{{%proposal}}',
            'task_id',
            '{{%task}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-proposal-user_id}}',
            '{{%proposal}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-proposal-user_id}}',
            '{{%proposal}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%task}}`
        $this->dropForeignKey(
            '{{%fk-proposal-task_id}}',
            '{{%proposal}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-proposal-task_id}}',
            '{{%proposal}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-proposal-user_id}}',
            '{{%proposal}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-proposal-user_id}}',
            '{{%proposal}}'
        );

        $this->dropTable('{{%proposal}}');
    }
}
