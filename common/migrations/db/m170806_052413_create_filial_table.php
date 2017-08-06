<?php

use yii\db\Migration;

/**
 * Handles the creation of table `filial`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 */
class m170806_052413_create_filial_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('filial', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(64)->null(),
            'organization_id' => $this->integer(),
            'city_id' => $this->integer(),
            'title' => $this->string(64)->notNull(),
            'alias' => $this->string(64)->notNull()->unique(),
            'body' => $this->text()->null(),
            'image' => $this->string(128)->null(),
            'map_lat' => $this->string(32)->null(),
            'map_lon' => $this->string(32)->null(),
            'map_zoom' => $this->smallInteger()->null(),
            'email' => $this->string(64)->null(),
            'site' => $this->string(64)->null(),
            'flamp' => $this->string(64)->null(),
            'phone' => $this->string(16)->null(),
            'settings' => $this->text()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()'),
            'status' => $this->smallInteger()->defaultValue(1),
            'lock' => $this->bigInteger()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-filial-city_id',
            'filial',
            'city_id'
        );

        $this->addForeignKey(
            'fk-filial-city_id',
            'filial',
            'city_id',
            'city',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-filial-organization_id',
            'filial',
            'organization_id'
        );

        $this->addForeignKey(
            'fk-filial-organization_id',
            'filial',
            'organization_id',
            'organization',
            'id',
            'CASCADE'
        );


        // creates index for column `created_by`
        $this->createIndex(
            'idx-filial-created_by',
            'filial',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-filial-created_by',
            'filial',
            'created_by',
            'user',
            'id',
            'SET NULL'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-filial-updated_by',
            'filial',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-filial-updated_by',
            'filial',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-filial-created_by',
            'filial'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-filial-created_by',
            'filial'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-filial-updated_by',
            'filial'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'idx-filial-updated_by',
            'filial'
        );

        $this->dropTable('filial');
    }
}
