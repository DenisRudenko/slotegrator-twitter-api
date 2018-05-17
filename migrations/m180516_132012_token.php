<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180516_132012_users
 */
class m180516_132012_token extends Migration
{
    public function up()
    {
        $this->createTable('token', [
            'id' => Schema::TYPE_PK,
            'oauth_token' => Schema::TYPE_STRING . ' NOT NULL',
            'oauth_token_secret' => Schema::TYPE_STRING . ' NOT NULL',
            'user_id' => Schema::TYPE_STRING . ' NOT NULL',
            'screen_name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('token');
    }
}
