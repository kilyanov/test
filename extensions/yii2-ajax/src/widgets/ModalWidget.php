<?php

declare(strict_types=1);

namespace kilyanov\ajax\widgets;

use kilyanov\ajax\assets\AjaxAsset;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Modal;

class ModalWidget extends Modal
{
    const MODAL_ID = 'js-ajax-modal';

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var string
     */
    public $size = Modal::SIZE_EXTRA_LARGE;

    /**
     * @var bool
     */
     public $closeButton = false;

    /**
     * @var string
     */
    public $footer = '';

    /**
     * @return void
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        $this->setId(self::MODAL_ID);
        $this->registerAsset();
        parent::init();
    }

    /**
     * @return void
     */
    protected function registerAsset(): void
    {
        AjaxAsset::register($this->getView());
    }
}
