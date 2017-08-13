<?php

use yii\db\Migration;

class m170813_072009_city_flamp_modify extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('city', 'flamp', $this->string(255)->after('settings'));
    }

    public function safeDown()
    {
        $this->alterColumn('city', 'flamp', $this->string(64)->after('settings'));
    }
}
