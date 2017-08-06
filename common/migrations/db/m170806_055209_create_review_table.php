<?php

use yii\db\Migration;

/**
 * Handles the creation of table `review`.
 * Has foreign keys to the tables:
 *
 * - `filial`
 * - `user`
 * - `user`
 */
class m170806_055209_create_review_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('review', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(64)->null(),
            'filial_id' => $this->integer()->notNull(),
            'user_name' => $this->string(128)->null(),
            'title' => $this->string(64)->notNull(),
            'body' => $this->text()->null(),
            'image' => $this->string(128)->null(),
            'rating' => $this->smallInteger()->unsigned()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()'),
            'lock' => $this->bigInteger()->defaultValue(0),
        ]);

        // creates index for column `filial_id`
        $this->createIndex(
            'idx-review-filial_id',
            'review',
            'filial_id'
        );

        // add foreign key for table `filial`
        $this->addForeignKey(
            'fk-review-filial_id',
            'review',
            'filial_id',
            'filial',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            'idx-review-created_by',
            'review',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-review-created_by',
            'review',
            'created_by',
            'user',
            'id',
            'SET NULL'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-review-updated_by',
            'review',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-review-updated_by',
            'review',
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
            'fk-review-filial_id',
            'review'
        );

        // drops index for column `filial_id`
        $this->dropIndex(
            'idx-review-filial_id',
            'review'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-review-created_by',
            'review'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-review-created_by',
            'review'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-review-updated_by',
            'review'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'idx-review-updated_by',
            'review'
        );

        $this->dropTable('review');
    }
}
