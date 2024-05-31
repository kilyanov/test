<?php

declare(strict_types=1);

namespace kilyanov\ajax\grid;

use kilyanov\ajax\grid\traits\HiddenAttributeTrait;
use yii\grid\DataColumn;

class HiddenColumn extends DataColumn
{
    use HiddenAttributeTrait;

    /**
     * @var string
     */
    public $attribute = 'hidden';

    /**
     * @var string
     */
    public $format = 'boolean';

    /**
     * @var string[]
     */
    public $headerOptions = ['style' => 'width:100px'];

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();
        $this->filter = self::getHiddenList();
    }
}
