<?php

namespace app\modules\organizator\models;

use app\modules\event\models\Event;
use app\modules\organizator\models\query\OrganizationEventQuery;
use kilyanov\behaviors\common\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%organization_event}}".
 *
 * @property int $id ID
 * @property int $organizatorId Организатор
 * @property int $eventId Мероприятие
 * @property string|null $createdAt
 * @property string|null $updatedAt
 *
 * @property Event $eventRelation
 * @property Organizator $organizatorRelation
 */
class OrganizationEvent extends ActiveRecord
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
        return '{{%organization_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['organizatorId', 'eventId'], 'required'],
            [['organizatorId', 'eventId'], 'integer'],
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
            'organizatorId' => 'Организатор',
            'eventId' => 'Мероприятие',
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
     * @return OrganizationEventQuery
     */
    public static function find()
    {
        return new OrganizationEventQuery(get_called_class());
    }
}
