<?php

declare(strict_types=1);

namespace app\models\search;

use app\modules\event\models\Event;
use app\modules\event\models\EventOrganization;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use app\modules\event\models\search\EventSearch as EventSearchAlias;

class EventSearch extends EventSearchAlias
{
    /**
     * @param array $params
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Event::find()->hidden()->joinWith(['eventOrganizationsRelation']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'dateEvent' => SORT_DESC,
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
