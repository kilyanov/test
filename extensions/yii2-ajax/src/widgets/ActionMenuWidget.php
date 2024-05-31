<?php

declare(strict_types=1);

namespace kilyanov\ajax\widgets;

use Exception;
use kilyanov\ajax\interfaces\ElementInterface;
use yii\bootstrap5\Widget;
use yii\helpers\ArrayHelper;

class ActionMenuWidget extends Widget
{
    const DEFAULT_ICON = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-menu-down" viewBox="0 0 16 16">
    <path d="M7.646.146a.5.5 0 0 1 .708 0L10.207 2H14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h3.793L7.646.146zM1 7v3h14V7H1zm14-1V4a1 1 0 0 0-1-1h-3.793a1 1 0 0 1-.707-.293L8 1.207l-1.5 1.5A1 1 0 0 1 5.793 3H2a1 1 0 0 0-1 1v2h14zm0 5H1v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zM2 4.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
</svg>';

    /**
     * @var string|null
     */
    public ?string $label = null;

    /**
     * @var array
     */
    public array $items = [];

    /**
     * @var array
     */
    public array $params = [];

    /**
     * @var array
     */
    public array $factory = [];

    /**
     * @return void
     * @throws Exception
     */
    public function init(): void
    {
        $factoryClass = ArrayHelper::getValue($this->factory, 'class');
        $items = $factoryClass::create($this->params);
        $this->items = array_map(
            function ($item) {
                /** @var ElementInterface $item */
                return $item->getData();
            },
            $items
        );
    }

    /**
     * @return string
     */
    public function run(): string
    {
        if (empty($this->items)) return '';

        return $this->render(
            'dropdown',
            [
                'items' => $this->items,
                'label' => ($this->label === null) ? self::DEFAULT_ICON : $this->label,
            ]
        );
    }
}
