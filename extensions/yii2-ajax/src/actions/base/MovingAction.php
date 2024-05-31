<?php

declare(strict_types=1);

namespace kilyanov\ajax\actions\base;

use kilyanov\ajax\controller\ApplicationController;

class MovingAction extends IndexAction
{
    /**
     * @return void
     */
    public function init(): void
    {
        $this->setTemplate('moving');
        /** @var ApplicationController $controller */
        $controller = $this->controller;
        $controller->setCfgSearchModel(['pageLimit' => false]);
    }
}
