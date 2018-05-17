<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180516_132030_feed_users
 */
class m180516_132030_feed_users extends Migration
{
    public function up()
    {
        $this->createTable('feed_users', [
            'id' => Schema::TYPE_PK,
            'user' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('feed_users');
    }
}
