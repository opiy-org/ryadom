<?php

use yii\db\Migration;

class m170813_041840_filial_flam_modify extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('filial', 'flamp', $this->string(255)->after('settings'));
    }

    public function safeDown()
    {
        $this->alterColumn('filial', 'flamp', $this->string(64)->after('settings'));
    }

}
