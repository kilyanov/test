<?php

declare(strict_types=1);

namespace app\common\traits;

use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

trait DefaultActiveQueryTrait
{
    /**
     * @param string|array|int $ids
     * @return ActiveQuery
     */
    public function ids(string|array|int $ids): ActiveQuery
    {
        /** @var ActiveQuery $this */
        return $this->andWhere([$this->modelClass::tableName() . '.[[id]]' => $ids]);
    }

    /**
     * @return array
     */
    public function asDropDown(): array
    {
        return ArrayHelper::map(
            $this->all(),
            'id',
            static function ($model) {
                return $model->getFullName();
            }
        );
    }
}
