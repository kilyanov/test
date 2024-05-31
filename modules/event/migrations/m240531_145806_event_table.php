<?php

use yii\db\Migration;

/**
 * Class m240531_145806_event_table
 */
class m240531_145806_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ?
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'name' => $this->string()->notNull()->comment('Название'),
            'dateEvent' => $this->date()->notNull()->comment('Дата проведения'),
            'description' => $this->text()->notNull()->comment('Описание мероприятия'),
            'hidden' => $this->smallInteger()->defaultValue(0)->comment('Скрыто'),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('idx-hidden', '{{%event}}', ['hidden']);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');

        return true;
    }
}
