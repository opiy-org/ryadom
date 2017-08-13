<?php

use yii\db\Migration;

class m170813_000545_add_address_filial extends Migration
{
    public function safeUp()
    {
        $this->addColumn('filial', 'street', $this->string(64)->after('image'));
        $this->addColumn('filial', 'bld', $this->string(16)->after('street'));
        $this->addColumn('filial', 'addr_extra', $this->string(64)->after('bld'));
    }

    public function safeDown()
    {
        $this->dropColumn('filial', 'street');
        $this->dropColumn('filial', 'bld');
        $this->dropColumn('filial', 'addr_extra');
    }


}
