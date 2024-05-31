<?php

declare(strict_types=1);

namespace app\commands;

use Exception;
use Yii;
use app\common\rbac\CollectionRolls;
use yii\console\Controller;

class RoleController extends Controller
{

    /**
     * @throws Exception
     */
    public function actionIndex(): void
    {
        $auth = Yii::$app->authManager;

        $roleRoot = $auth->createRole(CollectionRolls::ROLE_ROOT);
        $auth->add($roleRoot);
        echo 'Create role ROLE_ROOT' . PHP_EOL;

        $roleUser = $auth->createRole(CollectionRolls::ROLE_USER);
        $auth->add($roleUser);
        echo 'Create role ROLE_USER' . PHP_EOL;
        $auth->addChild($roleRoot, $roleUser);
    }

}
