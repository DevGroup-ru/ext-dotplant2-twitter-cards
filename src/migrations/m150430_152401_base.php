<?php

use yii\db\Schema;
use yii\db\Migration;

class m150430_152401_base extends Migration
{
    public function up()
    {
        $this->insert(
            '{{%configurable}}',
            [
                'module' => 'twitterCards',
                'sort_order' => 12,
                'section_name' => 'Twitter cards',
                'display_in_config' => 1,
            ]
        );
    }

    public function down()
    {
        $this->delete('{{%configurable}}', ['module' => 'twitterCards']);
    }
}