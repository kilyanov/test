<?php

namespace app\modules\organizator\models\query;

use app\common\traits\DefaultActiveQueryTrait;
use app\common\traits\HiddenActiveQueryTrait;
use app\modules\organizator\models\Organizator;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class OrganizatorQuery extends ActiveQuery
{
    use HiddenActiveQueryTrait;
    use DefaultActiveQueryTrait;

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
