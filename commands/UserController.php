<?php

declare(strict_types=1);

namespace app\commands;

use app\common\rbac\CollectionRolls;
use app\models\User;
use Exception;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $userRoot = new User([
            'username' => 'admin',
            'email' => 'admin@admin.loc',
            'status' => User::STATUS_ACTIVE,
        ]);
        $userRoot->setPassword('admin');
        $userRoot->generateAuthKey();
        $userRoot->save();
        $rootRole = $auth->getRole(CollectionRolls::ROLE_ROOT);
        $auth->assign($rootRole, $userRoot->getId());
    }
}
