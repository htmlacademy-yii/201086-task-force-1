<?php

use frontend\models\ChatMessages;
use yii\db\Migration;

/**
 * Class m201203_202845_add_demo_to_chat
 */
class m201203_202845_add_demo_to_chat extends Migration
{
    public function safeUp()
    {

        for ($i = 1; $i < 4; $i++) {
            ChatMessages::create($i, $i, 'test' . $i);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('chat_messages');

        return true;
    }
}
