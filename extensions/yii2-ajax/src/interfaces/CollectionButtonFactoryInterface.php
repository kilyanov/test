<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface CollectionButtonFactoryInterface
{
    /**
     * @return array
     */
    public static function create(): array;
}
