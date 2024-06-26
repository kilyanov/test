<?php

declare(strict_types=1);

namespace app\modules\event\models\search;

use app\modules\event\models\Event;
use app\modules\event\models\EventOrganization;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['hidden', 'id'], 'integer'],
            [['name', 'description'], 'string'],
            [['createdAt', 'updatedAt', 'dateEvent', 'organizationIds'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Event::find()->joinWith(['eventOrganizationsRelation']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'createdAt' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            Event::tableName() . '.[[hidden]]' => $this->hidden
        ])
            ->andFilterWhere([
                EventOrganization::tableName() . '.[[organizatorId]]' => $this->organizationIds
            ])
            ->andFilterWhere([
                Event::tableName() . '.[[id]]' => $this->id
            ])
            ->andFilterWhere([
                'like', Event::tableName() . '.[[name]]', $this->name
            ])
            ->andFilterWhere([
                'like', Event::tableName() . '.[[description]]', $this->description
            ]);
        if (!empty($this->dateEvent)) {
            $query->andFilterWhere([
                Event::tableName() . '.[[dateEvent]]' => Yii::$app->formatter->asDate($this->dateEvent, 'php:Y-m-d')
            ]);
        }

        return $dataProvider;
    }
}
