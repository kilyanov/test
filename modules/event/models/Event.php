<?php

namespace app\modules\event\models;

use app\modules\event\behaviors\DateEventBehavior;
use app\modules\event\models\query\EventQuery;
use app\modules\organizator\models\Organizator;
use kilyanov\ajax\grid\interface\HiddenAttributeInterface;
use kilyanov\ajax\grid\traits\HiddenAttributeTrait;
use kilyanov\behaviors\common\TimestampBehavior;
use voskobovich\linker\LinkerBehavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property array $organizationIds
 *
 * @property EventOrganization[] $eventOrganizationsRelation
 */
class Event extends ActiveRecord implements HiddenAttributeInterface
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
            'DateEventBehavior' => [
                'class' => DateEventBehavior::class,
            ],
            'LinkerBehavior' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'organizationIds' => [
                        'eventOrganizationsRelation',
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
            /** virtual */
            [['organizationIds'], 'each', 'rule' => ['integer']],
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
            /** virtual */
            'organizationIds' => 'Организаторы'
        ];
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getEventOrganizationsRelation(): ActiveQuery
    {
        return $this->hasMany(Organizator::class, ['id' => 'organizatorId'])
            ->viaTable(EventOrganization::tableName(), ['eventId' => 'id']);
    }

    /**
     * @return EventQuery
     */
    public static function find()
    {
        return new EventQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function asDropDown(): array
    {
        $models = self::find()->hidden()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }
}
