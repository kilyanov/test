<?php

namespace app\modules\admin\modules\organizator\grid;

use app\modules\event\models\Event;
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
class EventColumn extends DataColumn
{
    /**
     * @var string
     */
    public $attribute = 'eventIds';

    /**
     * @var string
     */
    public string $relation = 'organizationEventsRelation';

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
                    /** @var Event $item */
                    $result[] = $item->name;
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
            'data' => Event::asDropDown(),
            'options' => $options,
        ]);

        return parent::renderFilterCellContent();
    }
}
