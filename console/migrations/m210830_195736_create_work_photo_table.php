<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%work_photo}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210830_195736_create_work_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%work_photo}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(256),
            'url' => $this->string(256),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-work_photo-user_id}}',
            '{{%work_photo}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-work_photo-user_id}}',
            '{{%work_photo}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-work_photo-user_id}}',
            '{{%work_photo}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-work_photo-user_id}}',
            '{{%work_photo}}'
        );

        $this->dropTable('{{%work_photo}}');
    }
}
