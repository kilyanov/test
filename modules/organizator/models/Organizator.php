<?php

namespace app\modules\organizator\models;

use app\modules\event\models\Event;
use app\modules\event\models\EventOrganization;
use app\modules\organizator\models\query\OrganizatorQuery;
use kilyanov\ajax\grid\interface\HiddenAttributeInterface;
use kilyanov\ajax\grid\traits\HiddenAttributeTrait;
use kilyanov\behaviors\common\TimestampBehavior;
use voskobovich\linker\LinkerBehavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property array $eventIds
 *
 * @property EventOrganization[] $eventOrganizationsRelation
 */
class Organizator extends ActiveRecord implements HiddenAttributeInterface
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
            ['email', 'email'],
            ['email', 'unique'],
            ['phone', 'unique'],
            /** virtual */
            [['eventIds'], 'each', 'rule' => ['integer']],
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
            /** virtual */
            'eventIds' => 'События'
        ];
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getOrganizationEventsRelation(): ActiveQuery
    {
        return $this->hasMany(Event::class, ['id' => 'eventId'])
            ->viaTable(EventOrganization::tableName(), ['organizatorId' => 'id']);
    }

    /**
     * @return OrganizatorQuery
     */
    public static function find()
    {
        return new OrganizatorQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function asDropDown(): array
    {
        $models = self::find()->hidden()->all();
        return ArrayHelper::map($models, 'id', 'fio');
    }
}
