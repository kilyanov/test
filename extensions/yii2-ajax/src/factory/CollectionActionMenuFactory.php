<?php

declare(strict_types=1);

namespace kilyanov\ajax\factory;

use kilyanov\ajax\entity\UrlEntity;
use kilyanov\ajax\interfaces\CollectionActionMenuFactoryInterface;
use yii\helpers\ArrayHelper;

class CollectionActionMenuFactory implements CollectionActionMenuFactoryInterface
{
    /**
     * @param array $config
     * @return array
     */
    public static function create(array $config): array
    {
        return [
            new UrlEntity([
                'name' => 'Редактировать',
                'url' => ArrayHelper::merge(['update'], $config),
                'options' => [
                    'class' => 'dropdown-item',
                    'title' => 'Редактировать',
                    'role' => 'modal-remote'
                ]
            ]),
            new UrlEntity([
                'name' => 'Удалить',
                'url' => ArrayHelper::merge(['delete'], $config),
                'options' => [
                    'class' => 'dropdown-item',
                    'title' => 'Удалить',
                    'role' => 'modal-remote',
                    'data-confirm-title' => 'Подтверждение удаления!',
                    'data-confirm-message' => 'Вы уверены что хотите удалить запись?',
                ]
            ]),
        ];
    }
}
