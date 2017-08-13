<?php

use yii\db\Migration;

class m170812_123909_add_city_flamp extends Migration
{
    public function safeUp()
    {
        $this->addColumn('city', 'flamp', $this->string(64)->after('settings'));
    }

    public function safeDown()
    {
        $this->dropColumn('city', 'flamp');
    }
}
