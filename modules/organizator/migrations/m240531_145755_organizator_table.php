<?php

use yii\db\Migration;

/**
 * Class m240531_145755_organizator_table
 */
class m240531_145755_organizator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ?
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%organizator}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'fio' => $this->string()->notNull()->comment('ФИО'), //todo я юы разделил на Имя Фамилия Отчество
            'email' => $this->string()->notNull()->comment('E-mail'),
            'phone' => $this->string()->notNull()->comment('Телефон'),
            'hidden' => $this->smallInteger()->defaultValue(0)->comment('Скрыто'),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('idx-hidden', '{{%organizator}}', ['hidden']);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organizator}}');

        return true;
    }
}
