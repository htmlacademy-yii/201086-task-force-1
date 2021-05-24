<?php

use Faker\Factory;
use yii\db\Migration;

/**
 * Class m201203_200200_add_demo_to_task
 */
class m201203_200200_add_demo_to_task extends Migration
{
    public function safeUp()
    {
        $rows = [];
        for ($i = 1; $i < 10; $i++) {
            $faker = Factory::create();
            $rows[] = [
              $faker->word,
              $faker->numberBetween(1, 8),
              1,
              $faker->dateTime()->format('Y-m-d H:i:s'),
              $faker->numberBetween(1, 5),
              $faker->numberBetween(100, (int)time()),
              $faker->numberBetween(100, (int)time()),
              $faker->numberBetween(100, 10000),
              0,
            ];
        }
        $this->batchInsert('task', [
          'name',
          'category_id',
          'location_id',
          'deadline',
          'customer_id',
          'created_at',
          'updated_at',
          'budget',
          'status'
        ], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('task');

        return true;
    }
}
