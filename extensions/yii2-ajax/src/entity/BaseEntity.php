<?php

declare(strict_types=1);

namespace kilyanov\ajax\entity;

use yii\base\BaseObject;

/**
 *
 * @property-read string $data
 */
abstract class BaseEntity extends BaseObject
{
    /**
     * @return string
     */
    abstract function getData(): string;
}
