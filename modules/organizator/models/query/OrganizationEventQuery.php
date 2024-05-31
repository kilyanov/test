<?php

namespace app\modules\organizator\models\query;

use app\modules\organizator\models\OrganizationEvent;
use yii\db\ActiveRecord;

class OrganizationEventQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return OrganizationEvent[]|array
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
