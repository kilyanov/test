<?php

declare(strict_types=1);

namespace kilyanov\ajax\widgets;

use Exception;
use kilyanov\ajax\entity\UrlEntity;
use kilyanov\ajax\interfaces\ElementInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Widget;
use yii\helpers\ArrayHelper;

class GroupButtonWidget extends Widget
{
    /**
     * @var bool
     */
    public bool $isAjax = true;

    /**
     * @var array
     */
    public array $access = [];

    /**
     * @var array
     */
    public array $visible = [];

    /**
     * @var array
     */
    public array $configUrl = [];

    /**
     * @var array
     */
    public array $exceptionConfigUrl = [];

    /**
     * @var array
     */
    protected array $button = [];

    /**
     * @return void
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function init(): void
    {
        parent::init();
        $this->setButton();
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return implode(
            '',
            array_map(
                function ($button) {
                    /** @var ElementInterface $button */
                   return $button->getData();
                },
                $this->button
            )
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function setButton(): void
    {
        $this->button = [
            new UrlEntity([
                'name' => 'Добавить',
                'url' => ArrayHelper::merge(['create'], $this->configUrl),
                'options' => $this->isAjax ?
                    ['class' => 'btn btn-primary', 'role' => 'modal-remote'] :
                    ['class' => 'btn btn-primary'],
                'listAccess' => ArrayHelper::getValue($this->access, 'create', Yii::$app->controller->getListAccess()),
                'visible' => ArrayHelper::getValue($this->visible, 'create', true),
            ]),
            new UrlEntity([
                'name' => 'Сбросить',
                'url' => in_array('index', $this->exceptionConfigUrl) ? ['index'] :
                    ArrayHelper::merge(['index'], $this->configUrl),
                'options' => ['class' => 'btn btn-secondary'],
                'listAccess' => ArrayHelper::getValue($this->access, 'index', Yii::$app->controller->getListAccess()),
                'visible' => ArrayHelper::getValue($this->visible, 'index', true),
            ])
        ];
    }
}
