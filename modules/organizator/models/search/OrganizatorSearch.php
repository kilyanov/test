<?php

declare(strict_types=1);

namespace app\modules\organizator\models\search;

use app\modules\organizator\models\Organizator;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizatorSearch extends Organizator
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['hidden', 'id'], 'integer'],
            [['fio', 'email', 'phone'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
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
        $query = Organizator::find()->hidden();

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
            Organizator::tableName() . '.[[hidden]]' => $this->hidden
        ])
            ->andFilterWhere([
                Organizator::tableName() . '.[[id]]' => $this->id
            ])
            ->andFilterWhere([
                'like', Organizator::tableName() . '.[[fio]]', $this->fio
            ])
            ->andFilterWhere([
                'like', Organizator::tableName() . '.[[email]]', $this->email
            ])
            ->andFilterWhere([
                'like', Organizator::tableName() . '.[[phone]]', $this->phone
            ]);

        return $dataProvider;
    }
}
