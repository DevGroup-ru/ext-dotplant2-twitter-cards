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
        $this->createTable(
            '{{%object_twitter_card}}',
            [
                'id' => Schema::TYPE_PK,
                'object_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'object_model_id' => Schema::TYPE_INTEGER .' NOT NULL',
                'active' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
                'title' => Schema::TYPE_STRING.' NOT NULL',
                'description' => Schema::TYPE_TEXT.' NOT NULL',
                'image' => Schema::TYPE_STRING
            ]
        );
    }

    public function down()
    {
        $this->delete('{{%configurable}}', ['module' => 'twitterCards']);
        $this->dropTable('{{%object_twitter_card}}');
    }
}