<?php

declare(strict_types=1);

namespace kilyanov\ajax\grid;

use kilyanov\ajax\factory\CollectionActionMenuFactory;
use kilyanov\ajax\widgets\ActionMenuWidget;
use yii\grid\ActionColumn as ActionColumnAlias;

class ActionColumn extends ActionColumnAlias
{
    /**
     * @var string
     */
    public string $actionMenuWidget = ActionMenuWidget::class;

    /**
     * @var array
     */
    public array $factory = [
        'class' => CollectionActionMenuFactory::class
    ];

    /**
     * @var string
     */
    public $template = '{menu}';

    /**
     * @var string
     */
    public $headerOptions = ['style' => 'width:20px'];

    /**
     * @var string
     */
    public $header = '';

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();
        $this->buttons = [
            'menu' => function ($url, $model) {
                return $this->actionMenuWidget::widget([
                    'params' => ['id' => $model->id],
                    'factory' => $this->factory
                ]);
            }
        ];
    }
}
