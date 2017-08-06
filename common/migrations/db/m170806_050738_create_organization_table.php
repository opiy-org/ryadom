<?php

use yii\db\Migration;

/**
 * Handles the creation of table `organization`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 */
class m170806_050738_create_organization_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('organization', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(64)->null(),
            'title' => $this->string(64)->notNull(),
            'alias' => $this->string(64)->notNull()->unique(),
            'body' => $this->text()->null(),
            'image' => $this->string(128)->null(),
            'inn' => $this->string(32)->null(),
            'kpp' => $this->string(32)->null(),
            'ogrn' => $this->string(32)->null(),
            'email' => $this->string(64)->null(),
            'site' => $this->string(64)->null(),
            'phone' => $this->string(16)->null(),
            'bank_props' => $this->text()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->defaultExpression('NOW()'),
            'status' => $this->smallInteger()->defaultValue(1),
            'lock' => $this->bigInteger()->defaultValue(0),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            'idx-organization-created_by',
            'organization',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-organization-created_by',
            'organization',
            'created_by',
            'user',
            'id',
            'SET NULL'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'idx-organization-updated_by',
            'organization',
            'updated_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-organization-updated_by',
            'organization',
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
            'fk-organization-created_by',
            'organization'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-organization-created_by',
            'organization'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-organization-updated_by',
            'organization'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'idx-organization-updated_by',
            'organization'
        );

        $this->dropTable('organization');
    }
}
