<?php

use yii\db\Migration;

/**
 * Class m240531_150755_event_organization_table
 */
class m240531_150755_event_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ?
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%event_organization}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'eventId' => $this->integer()->notNull()->comment('Мероприятие'),
            'organizatorId' => $this->integer()->notNull()->comment('Организатор'),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('idx-eventId-event_organization', '{{%event_organization}}', ['eventId']);
        $this->addForeignKey(
            'fk-event_organization-eventId-event',
            '{{%event_organization}}',
            ['eventId'],
            '{{%event}}',
            ['id'],
            'CASCADE',
            'RESTRICT'
        );

        $this->createIndex('idx-organizatorId-event_organizator', '{{%event_organization}}', ['organizatorId']);
        $this->addForeignKey(
            'fk-event_organization-organizatorId-organization',
            '{{%event_organization}}',
            ['organizatorId'],
            '{{%organizator}}',
            ['id'],
            'CASCADE',
            'RESTRICT'
        );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-event_organization-organizatorId-organization', '{{%event_organization}}');
        $this->dropForeignKey('fk-event_organization-eventId-event', '{{%event_organization}}');
        $this->dropTable('{{%event_organization}}');

        return true;
    }
}
