<?php

namespace app\modules\organizator\models\query;

use app\modules\organizator\models\Organizator;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class OrganizatorQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Organizator[]|array
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
