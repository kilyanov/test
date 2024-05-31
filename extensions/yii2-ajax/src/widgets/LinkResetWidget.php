<?php

declare(strict_types=1);

namespace kilyanov\ajax\widgets;

use Exception;
use kilyanov\ajax\entity\UrlEntity;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class LinkResetWidget extends GroupButtonWidget
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
                'name' => 'Сбросить фильтр',
                'url' => ArrayHelper::merge([''], $this->configUrl),
                'options' => ['class' => 'btn btn-secondary'],
                'listAccess' => ArrayHelper::getValue($this->access, 'index', Yii::$app->controller->getListAccess()),
                'visible' => ArrayHelper::getValue($this->visible, 'index', true),
            ]),
        ];
    }
}
