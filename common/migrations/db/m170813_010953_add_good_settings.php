<?php

use yii\db\Migration;

class m170813_010953_add_good_settings extends Migration
{
    public function safeUp()
    {
        $this->addColumn('good', 'settings', $this->text()->null()->after('price'));
    }

    public function safeDown()
    {
        $this->dropColumn('good', 'settings');
    }


}
