<?php

declare(strict_types=1);

namespace kilyanov\ajax\controller;

interface ControllerInterface
{
    /**
     * @return array
     */
    public function getExportAttribute(): array;
}
