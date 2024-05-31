<?php

namespace app\modules\admin\modules\event\controllers;

use app\modules\event\models\Event;
use app\modules\event\models\search\EventSearch;
use kilyanov\ajax\controller\ApplicationController;

class DefaultController extends ApplicationController
{
    /**
     * @return void
     */
    public function init(): void
    {
        $this->setModelClass(Event::class);
        $this->setSearchModelClass(EventSearch::class);
        parent::init();
    }
}
