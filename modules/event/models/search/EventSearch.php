<?php

declare(strict_types=1);

namespace app\modules\event\models\search;

use app\modules\event\models\Event;
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
            [['createdAt', 'updatedAt', 'dateEvent'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Event::find()->hidden();

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
                Event::tableName() . '.[[id]]' => $this->id
            ])
            ->andFilterWhere([
                'like', Event::tableName() . '.[[name]]', $this->name
            ])
            ->andFilterWhere([
                'like', Event::tableName() . '.[[description]]', $this->description
            ])
            ->andFilterWhere([
                'like', Event::tableName() . '.[[dateEvent]]', $this->dateEvent
            ]);

        return $dataProvider;
    }
}
