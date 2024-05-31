<?php

namespace app\modules\event\models\query;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class EventOrganizationQuery extends ActiveQuery
{
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
