<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface CollectionActionMenuFactoryInterface
{
    /**
     * @param array $config
     * @return array
     */
    public static function create(array $config): array;
}
