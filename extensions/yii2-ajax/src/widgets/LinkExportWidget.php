<?php

declare(strict_types=1);

namespace kilyanov\ajax\widgets;

use Exception;
use kilyanov\ajax\entity\UrlEntity;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class LinkExportWidget extends GroupButtonWidget
{
    /**
     * @return void
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function init(): void
    {
        parent::init();
        $this->button = [
            new UrlEntity([
                'name' => 'Экспорт',
                'url' => ArrayHelper::merge(['export'], $this->configUrl),
                'options' => ['data-pjax' => 0, 'class' => 'btn btn-success float-end'],
                'listAccess' => ArrayHelper::getValue($this->access, 'export', Yii::$app->controller->getListAccess()),
                'visible' => ArrayHelper::getValue($this->visible, 'export', true),
            ])
        ];
    }
}
