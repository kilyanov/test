<?php

namespace app\modules\organizator\models;

use app\modules\event\models\EventOrganization;
use app\modules\organizator\models\query\OrganizatorQuery;
use kilyanov\behaviors\common\TimestampBehavior;
use voskobovich\linker\LinkerBehavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%organizator}}".
 *
 * @property int $id ID
 * @property string $fio ФИО
 * @property string $email E-mail
 * @property string $phone Телефон
 * @property int|null $hidden Скрыто
 * @property string|null $createdAt
 * @property string|null $updatedAt
 *
 * @property EventOrganization[] $eventOrganizationsRelation
 * @property OrganizationEvent[] $organizationEventsRelation
 */
class Organizator extends ActiveRecord
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
            'LinkerBehavior' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'eventIds' => [
                        'organizationEventsRelation',
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
        return '{{%organizator}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fio', 'email', 'phone'], 'required'],
            [['hidden'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['fio', 'email', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'hidden' => 'Скрыто',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEventOrganizationsRelation()
    {
        return $this->hasMany(EventOrganization::class, ['organizatorId' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getOrganizationEventsRelation()
    {
        return $this->hasMany(OrganizationEvent::class, ['id' => 'organizatorId'])
            ->viaTable(OrganizationEvent::tableName(), ['organizatorId' => 'id']);
    }

    /**
     * @return OrganizatorQuery
     */
    public static function find()
    {
        return new OrganizatorQuery(get_called_class());
    }
}
