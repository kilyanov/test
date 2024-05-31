<?php

declare(strict_types=1);

namespace kilyanov\ajax\actions\base;

use kilyanov\ajax\controller\ApplicationController;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeleteAction extends BaseAction
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(): array
    {
        /** @var ApplicationController $controller */
        $controller = $this->controller;
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($this->getModel()->delete()) {
                return $controller->getAnswer()->isDelete();
            } else {
                $this->setErrorSaveData();
                return $controller->getAnswer()->isPost();
            }
        } else {
            throw new NotFoundHttpException('Request is not Ajax.');
        }
    }

    /**
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function runWithParams($params)
    {
        /** @var ApplicationController $controller */
        $controller = $this->controller;
        $model = $controller->findModel((string)$params['id']);
        $this->setModel($model);
        $controller->getAnswer()
            ->setContainerReload($controller->getForceReload())
            ->setTitle('Удаление записи');

        return parent::runWithParams($params);
    }
}
