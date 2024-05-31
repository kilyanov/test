<?php

use yii\db\Migration;

class m220905_032809_init extends Migration
{
    public const TABLE_NAME = 'user';

    private string $table = '{{%' . self::TABLE_NAME . '}}';

    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ?
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable($this->table, [
            'id' => $this->primaryKey()->comment('ID'),
            'username' => $this->string()->notNull()->unique()->comment('Логин'),
            'auth_key' => $this->string(32)->notNull()->comment('Ключ'),
            'password_hash' => $this->string()->notNull()->comment('Пароль'),
            'password_reset_token' => $this->string()->unique()->defaultValue(null)->comment('Токен для сброса пароля'),
            'email' => $this->string()->notNull()->unique()->comment('Email'),
            'verification_token' => $this->string()->null()->defaultValue(null)->comment('Токен регистрации'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
        ], $options);
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
