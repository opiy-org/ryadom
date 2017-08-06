<?php

use yii\db\Migration;

/**
 * Handles the creation of table `good`.
 * Has foreign keys to the tables:
 *
 * - `filial`
 * - `user`
 * - `user`
 */
class m170806_054648_create_good_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('good', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(64)->null(),
            'filial_id' => $this->integer()->notNull(),
            'title' => $this->string(64)->notNull(),
            'body' => $this->text()->null(),
            'image' => $this->string(128)->null(),
            'qnt' => $this->integer()->unsigned()->null(),
            'price' => $this->decimal(8,2),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()'),
            'lock' => $this->bigInteger()->defaultValue(0),
        ]);

        // creates index for column `filial_id`
        $this->createIndex(
            'idx-good-filial_id',
            'good',
            'filial_id'
        );

        // add foreign key for table `filial`
        $this->addForeignKey(
            'fk-good-filial_id',
            'good',
            'filial_id',
            'filial',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            'idx-good-created_by',
            'good',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-good-created_by',
            'good',
            'created_by',
            'user',
            'id',
            'SET NULL'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-good-updated_by',
            'good',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-good-updated_by',
            'good',
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
        // drops foreign key for table `filial`
        $this->dropForeignKey(
            'fk-good-filial_id',
            'good'
        );

        // drops index for column `filial_id`
        $this->dropIndex(
            'idx-good-filial_id',
            'good'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-good-created_by',
            'good'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-good-created_by',
            'good'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-good-updated_by',
            'good'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'idx-good-updated_by',
            'good'
        );

        $this->dropTable('good');
    }
}
