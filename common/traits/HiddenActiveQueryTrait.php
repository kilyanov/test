<?php

declare(strict_types=1);

namespace app\common\traits;

use kilyanov\ajax\grid\interface\HiddenAttributeInterface;
use yii\db\ActiveQuery;

trait HiddenActiveQueryTrait
{
    /**
     * @param int|null $hidden
     * @return ActiveQuery
     */
    public function hidden(?int $hidden = HiddenAttributeInterface::HIDDEN_NO): ActiveQuery
    {
        /** @var ActiveQuery $this */
        $this->andFilterWhere([$this->modelClass::tableName() . '.[[hidden]]' => $hidden]);
        return $this;
    }
}
