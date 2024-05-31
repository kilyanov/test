<?php

namespace app\modules\event\models;

use app\modules\event\models\query\EventOrganizationQuery;
use app\modules\organizator\models\Organizator;
use kilyanov\behaviors\common\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%event_organization}}".
 *
 * @property int $id ID
 * @property int $eventId Мероприятие
 * @property int $organizatorId Организатор
 * @property string|null $createdAt
 * @property string|null $updatedAt
 *
 * @property Event $eventRelation
 * @property Organizator $organizatorRelation
 */
class EventOrganization extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%event_organization}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['eventId', 'organizatorId'], 'required'],
            [['eventId', 'organizatorId'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [
                ['eventId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Event::class,
                'targetAttribute' => ['eventId' => 'id']
            ],
            [
                ['organizatorId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Organizator::class,
                'targetAttribute' => ['organizatorId' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'eventId' => 'Мероприятие',
            'organizatorId' => 'Организатор',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEventRelation()
    {
        return $this->hasOne(Event::class, ['id' => 'eventId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOrganizatorRelation()
    {
        return $this->hasOne(Organizator::class, ['id' => 'organizatorId']);
    }

    /**
     * @return EventOrganizationQuery
     */
    public static function find()
    {
        return new EventOrganizationQuery(get_called_class());
    }
}
