<?php

declare(strict_types=1);

namespace kilyanov\ajax\entity;

use yii\bootstrap5\Html;

class ButtonEntity extends ElementEntity
{
    /**
     * @return string
     */
    public function getData(): string
    {
        if (!$this->isAccess() || !$this->isVisible()) {
            return '';
        }

        return Html::button($this->getName(), $this->getOptions());
    }
}
