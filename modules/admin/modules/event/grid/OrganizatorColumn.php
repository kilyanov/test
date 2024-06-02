<?php

namespace app\modules\admin\modules\event\grid;

use app\modules\organizator\models\Organizator;
use Exception;
use kartik\select2\Select2;
use Throwable;
use yii\db\ActiveRecord;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;

/**
 *
 * @property-read array $items
 */
class OrganizatorColumn extends DataColumn
{
    /**
     * @var string
     */
    public $attribute = 'organizationIds';

    /**
     * @var string
     */
    public string $relation = 'eventOrganizationsRelation';

    /**
     * @throws Exception
     */
    public function getDataCellValue($model, $key, $index)
    {
        /** @var ActiveRecord $model */
        if ($this->value === null) {
            if ($relation = ArrayHelper::getValue($model, [$this->relation])) {
                $result = [];
                foreach ($relation as $item) {
                    /** @var Organizator $item */
                    $result[] = $item->fio;
                }

                return implode(', ', $result);
            }
            return '';
        }

        return parent::getDataCellValue($model, $key, $index);
    }

    /**
     * @return string
     * @throws Throwable
     */
    protected function renderFilterCellContent(): string
    {
        $options = array_merge(['prompt' => ''], $this->filterInputOptions);

        $this->filter = Select2::widget([
            'model' => $this->grid->filterModel,
            'attribute' => $this->attribute,
            'data' => Organizator::asDropDown(),
            'options' => $options,
        ]);

        return parent::renderFilterCellContent();
    }
}
