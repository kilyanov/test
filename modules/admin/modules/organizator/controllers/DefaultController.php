<?php

namespace app\modules\admin\modules\organizator\controllers;

use app\common\rbac\CollectionRolls;
use app\modules\organizator\models\Organizator;
use app\modules\organizator\models\search\OrganizatorSearch;
use kilyanov\ajax\controller\ApplicationController;

class DefaultController extends ApplicationController
{
    /**
     * @return void
     */
    public function init(): void
    {
        $this->setListAccess([CollectionRolls::ROLE_ROOT]);
        $this->setModelClass(Organizator::class);
        $this->setSearchModelClass(OrganizatorSearch::class);
        parent::init();
        $this->layout = '/main-admin';
    }
}
