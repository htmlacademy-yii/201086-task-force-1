<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m201203_194438_add_demo_to_user
 */
class m201203_194438_add_demo_to_user extends Migration
{
    public function safeUp()
    {

        for ($i = 1; $i < 6; $i++) {
            $user = 'test' . $i;
            User::create($user, $user . '@i.ua', 1, 111);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('user');

        return true;
    }
}
