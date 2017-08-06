<?php

use yii\db\Migration;

/**
 * Handles the creation of table `city`.
 * Has foreign keys to the tables:
 *
 * - `created_by`
 * - `updated_by`
 */
class m170805_193051_create_city_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(64)->null(),
            'title' => $this->string(64)->notNull(),
            'alias' => $this->string(64)->notNull()->unique(),
            'body' => $this->text()->null(),
            'image' => $this->string(128)->null(),
            'map_lat' => $this->string(32)->null(),
            'map_lon' => $this->string(32)->null(),
            'map_zoom' => $this->smallInteger()->null(),
            'timezone' => $this->string(32)->null(),
            'settings' => $this->text()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()'),
            'status' => $this->smallInteger()->defaultValue(1),
            'lock' => $this->bigInteger()->defaultValue(0),
        ]);


        $this->createIndex(
            'idx-city-status',
            'city',
            'status'
        );

        $this->createIndex(
            'idx-city-alias',
            'city',
            'alias'
        );


        // creates index for column `created_by`
        $this->createIndex(
            'idx-city-created_by',
            'city',
            'created_by'
        );

        // add foreign key for table `created_by`
        $this->addForeignKey(
            'fk-city-created_by',
            'city',
            'created_by',
            'user',
            'id',
            'SET NULL'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-city-updated_by',
            'city',
            'updated_by'
        );

        // add foreign key for table `updated_by`
        $this->addForeignKey(
            'fk-city-updated_by',
            'city',
            'updated_by',
            'user',
            'id',
            'SET NULL'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

        // drops foreign key for table `updated_by`
        $this->dropForeignKey(
            'fk-city-updated_by',
            'city'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'idx-city-updated_by',
            'city'
        );


        // drops foreign key for table `created_by`
        $this->dropForeignKey(
            'fk-city-created_by',
            'city'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-city-created_by',
            'city'
        );


        $this->dropIndex(
            'idx-city-alias',
            'city'
        );

        $this->dropIndex(
            'idx-city-status',
            'city'
        );

        $this->dropTable('city');
    }
}
