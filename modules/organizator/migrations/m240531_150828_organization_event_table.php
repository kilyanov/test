<?php

use yii\db\Migration;

/**
 * Class m240531_150828_organization_event_table
 */
class m240531_150828_organization_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ?
            'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%organization_event}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'organizatorId' => $this->integer()->notNull()->comment('Организатор'),
            'eventId' => $this->integer()->notNull()->comment('Мероприятие'),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('idx-eventId-organization_event', '{{%organization_event}}', ['eventId']);
        $this->addForeignKey(
            'fk-organization_event-eventId-event',
            '{{%organization_event}}',
            ['eventId'],
            '{{%event}}',
            ['id'],
            'CASCADE',
            'RESTRICT'
        );

        $this->createIndex('idx-organizatorId-organization_event', '{{%organization_event}}', ['organizatorId']);
        $this->addForeignKey(
            'fk-organization_event-organizationId-organizator',
            '{{%organization_event}}',
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
        $this->dropForeignKey('fk-organization_event-eventId-event', '{{%organization_event}}');
        $this->dropForeignKey('fk-organization_event-organizationId-organizator', '{{%organization_event}}');
        $this->dropTable('{{%organization_event}}');

        return true;
    }
}
