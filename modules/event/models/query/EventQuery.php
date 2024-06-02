<?php

namespace app\modules\event\models\query;

use app\common\traits\DefaultActiveQueryTrait;
use app\common\traits\HiddenActiveQueryTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class EventQuery extends ActiveQuery
{
    use HiddenActiveQueryTrait;
    use DefaultActiveQueryTrait;

    /**
     * @param $db
     * @return array|ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param $db
     * @return array|ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
