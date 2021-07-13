<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'location_id' => $this->integer()->notNull(),
            'birthday' => $this->integer(),
            'info' => $this->text(),
            'phone' => $this->string(128),
            'skype' => $this->string(128),
            'another_messenger' => $this->string(128),
            'show_contacts_for_customer' => $this->tinyInteger(),
            'hide_profile' => $this->tinyInteger(),
            'last_visit_time' => $this->dateTime()->defaultValue(null),
            'count_orders' => $this->integer()->defaultValue(0),
            'popularity' => $this->integer()->defaultValue(0),
            'now_free' => $this->tinyInteger()->defaultValue(0),
          'has_reviews' => $this->tinyInteger()->defaultValue(0),
          'is_executor' => $this->tinyInteger()->defaultValue(0),
          'count_reviews' => $this->integer()->defaultValue(0),
          'rating' => $this->integer(11)->defaultValue(0),

          'status' => $this->smallInteger()->notNull()->defaultValue(10),
          'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
