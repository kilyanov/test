<?php

declare(strict_types=1);

namespace kilyanov\ajax\factory;

use kilyanov\ajax\entity\ButtonEntity;
use kilyanov\ajax\interfaces\CollectionButtonFactoryInterface;

class CollectionButtonCloseFactory implements CollectionButtonFactoryInterface
{
    /**
     * @return ButtonEntity[]
     */
    public static function create(): array
    {
        return [
            new ButtonEntity([
                'name' => 'Закрыть',
                'options' => [
                    'type' => 'button',
                    'class' => 'btn btn-secondary',
                    'data-bs-dismiss' => 'modal'
                ]
            ]),
        ];
    }
}
