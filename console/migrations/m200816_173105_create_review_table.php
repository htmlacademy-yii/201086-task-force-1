<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 * - `{{%task}}`
 */
class m200816_173105_create_review_table extends Migration
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
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'creation_time' => $this->dateTime()->notNull(),
            'customer_id' => $this->integer(),
            'executor_id' => $this->integer(),
            'assessment' => $this->integer(),
            'task_id' => $this->integer(),
            'comment' => $this->text(),
        ], $tableOptions);

        // creates index for column `customer_id`
        $this->createIndex(
            '{{%idx-review-customer_id}}',
            '{{%review}}',
            'customer_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-review-customer_id}}',
            '{{%review}}',
            'customer_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `executor_id`
        $this->createIndex(
            '{{%idx-review-executor_id}}',
            '{{%review}}',
            'executor_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-review-executor_id}}',
            '{{%review}}',
            'executor_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `task_id`
        $this->createIndex(
            '{{%idx-review-task_id}}',
            '{{%review}}',
            'task_id'
        );

        // add foreign key for table `{{%task}}`
        $this->addForeignKey(
            '{{%fk-review-task_id}}',
            '{{%review}}',
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
            '{{%fk-review-customer_id}}',
            '{{%review}}'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            '{{%idx-review-customer_id}}',
            '{{%review}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-review-executor_id}}',
            '{{%review}}'
        );

        // drops index for column `executor_id`
        $this->dropIndex(
            '{{%idx-review-executor_id}}',
            '{{%review}}'
        );

        // drops foreign key for table `{{%task}}`
        $this->dropForeignKey(
            '{{%fk-review-task_id}}',
            '{{%review}}'
        );

        // drops index for column `task_id`
        $this->dropIndex(
            '{{%idx-review-task_id}}',
            '{{%review}}'
        );

        $this->dropTable('{{%review}}');
    }
}
