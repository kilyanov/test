<?php

declare(strict_types=1);

namespace kilyanov\ajax\actions\base;

use kilyanov\ajax\controller\ApplicationController;
use kilyanov\ajax\factory\CollectionButtonCreateFactory;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class CopyAction extends BaseAction
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(): array
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            return $this->getAnswer();
        } else {
            throw new NotFoundHttpException('Request is not Ajax.');
        }
    }

    /**
     * @param $params
     * @return mixed
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function runWithParams($params): mixed
    {
        /** @var ApplicationController $controller */
        $controller = $this->controller;
        $modelClass = $controller->getModelClass();
        $createModel = new $modelClass();
        if ($createModel instanceof ActiveRecord) {
            $model = $controller->findModel((string)$params['id']);
            $attributes = $model->getAttributes();
            unset($attributes['id']);
            $createModel->setAttributes($attributes);
        }

        $this->setModel($createModel);
        $controller->getAnswer()
            ->setTitle('Копирование записи')
            ->getFooter()->setElements(CollectionButtonCreateFactory::create());
        $controller->getAnswer()
            ->setContainerReload($controller->getForceReload())
            ->getContent()
            ->setTemplate('copy')
            ->setParams([
                'model' => $this->getModel(),
                'listAccess' => $controller->getListAccess(),
            ]);

        return parent::runWithParams($params);
    }
}
