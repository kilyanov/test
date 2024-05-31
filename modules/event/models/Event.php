<?php

namespace app\modules\event\models;

use app\modules\event\models\query\EventQuery;
use app\modules\organizator\models\OrganizationEvent;
use kilyanov\ajax\grid\traits\HiddenAttributeTrait;
use kilyanov\behaviors\common\TimestampBehavior;
use voskobovich\linker\LinkerBehavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%event}}".
 *
 * @property int $id ID
 * @property string $name Название
 * @property string $dateEvent Дата проведения
 * @property string $description Описание мероприятия
 * @property int|null $hidden Скрыто
 * @property string|null $createdAt
 * @property string|null $updatedAt
 *
 * @property EventOrganization[] $eventOrganizationsRelation
 * @property OrganizationEvent[] $organizationEventsRelation
 */
class Event extends ActiveRecord
{
    use HiddenAttributeTrait;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
            'LinkerBehavior' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'organizationIds' => [
                        'servicesRelation',
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'dateEvent', 'description'], 'required'],
            [['dateEvent', 'createdAt', 'updatedAt'], 'safe'],
            [['description'], 'string'],
            [['hidden'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'dateEvent' => 'Дата проведения',
            'description' => 'Описание мероприятия',
            'hidden' => 'Скрыто',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getEventOrganizationsRelation()
    {
        return $this->hasMany(EventOrganization::class, ['id' => 'eventId'])
            ->viaTable(EventOrganization::tableName(), ['eventId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOrganizationEventsRelation()
    {
        return $this->hasMany(OrganizationEvent::class, ['eventId' => 'id']);
    }

    /**
     * @return EventQuery
     */
    public static function find()
    {
        return new EventQuery(get_called_class());
    }
}
