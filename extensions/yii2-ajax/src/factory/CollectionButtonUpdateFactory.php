<?php

declare(strict_types=1);

namespace kilyanov\ajax\factory;

use kilyanov\ajax\entity\ButtonEntity;
use kilyanov\ajax\entity\UrlEntity;
use kilyanov\ajax\interfaces\CollectionButtonFactoryInterface;

class CollectionButtonUpdateFactory implements CollectionButtonFactoryInterface
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
            new UrlEntity([
                'name' => 'Создать ещё',
                'url' => ['create'],
                'options' => [
                    'class' => 'btn btn-success',
                    'role' => 'modal-remote'
                ]
            ]),
        ];
    }
}
