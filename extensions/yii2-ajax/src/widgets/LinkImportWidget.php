<?php

declare(strict_types=1);

namespace kilyanov\ajax\widgets;

use Exception;
use kilyanov\ajax\entity\UrlEntity;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class LinkImportWidget extends GroupButtonWidget
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
                'name' => 'Импорт',
                'url' => ArrayHelper::merge(['import'], $this->configUrl),
                'options' => $this->isAjax ?
                    ['class' => 'btn btn-primary', 'role' => 'modal-remote'] :
                    ['class' => 'btn btn-primary'],
                'listAccess' => ArrayHelper::getValue($this->access, 'create', Yii::$app->controller->getListAccess()),
                'visible' => ArrayHelper::getValue($this->visible, 'import', true),
            ]),
        ];
    }
}
