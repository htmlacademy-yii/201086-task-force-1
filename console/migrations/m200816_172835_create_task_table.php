<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%categories}}`
 * - `{{%locations}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m200816_172835_create_task_table extends Migration
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
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'category_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'location_id' => $this->integer(),
            'budget' => $this->integer(),
            'deadline' => $this->dateTime()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'executor_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-task-category_id}}',
            '{{%task}}',
            'category_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-task-category_id}}',
            '{{%task}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        // creates index for column `location_id`
        $this->createIndex(
            '{{%idx-task-location_id}}',
            '{{%task}}',
            'location_id'
        );

        // add foreign key for table `{{%locations}}`
        $this->addForeignKey(
            '{{%fk-task-location_id}}',
            '{{%task}}',
            'location_id',
            '{{%locations}}',
            'id',
            'CASCADE'
        );

        // creates index for column `customer_id`
        $this->createIndex(
            '{{%idx-task-customer_id}}',
            '{{%task}}',
            'customer_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-task-customer_id}}',
            '{{%task}}',
            'customer_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `executor_id`
        $this->createIndex(
            '{{%idx-task-executor_id}}',
            '{{%task}}',
            'executor_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-task-executor_id}}',
            '{{%task}}',
            'executor_id',
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
        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-task-category_id}}',
            '{{%task}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-task-category_id}}',
            '{{%task}}'
        );

        // drops foreign key for table `{{%locations}}`
        $this->dropForeignKey(
            '{{%fk-task-location_id}}',
            '{{%task}}'
        );

        // drops index for column `location_id`
        $this->dropIndex(
            '{{%idx-task-location_id}}',
            '{{%task}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-task-customer_id}}',
            '{{%task}}'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            '{{%idx-task-customer_id}}',
            '{{%task}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-task-executor_id}}',
            '{{%task}}'
        );

        // drops index for column `executor_id`
        $this->dropIndex(
            '{{%idx-task-executor_id}}',
            '{{%task}}'
        );

        $this->dropTable('{{%task}}');
    }
}
