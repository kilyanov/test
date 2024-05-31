<?php

declare(strict_types=1);

namespace kilyanov\ajax\actions\base;

use Exception;
use kilyanov\ajax\controller\ApplicationController;
use kilyanov\ajax\factory\CollectionButtonCloseFactory;
use kilyanov\ajax\grid\interface\HiddenAttributeInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeleteAllAction extends BaseAction
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
            $params = explode(',', $request->post('ids'));
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $classNameModel = $controller->getModelClass();
                /** @var ActiveRecord $classNameModel */
                $model = new $classNameModel();
                if ($model->hasProperty('hidden')) {
                    $classNameModel::updateAll(
                        [$classNameModel::tableName() . '.[[hidden]]' => HiddenAttributeInterface::HIDDEN_YES],
                        [$classNameModel::tableName() . '.[[id]]' => $params]
                    );
                }
                else {
                    $classNameModel::deleteAll([
                        $classNameModel::tableName() . '.[[id]]' => $params
                    ]);
                }
                $transaction->commit();
                $controller
                    ->getAnswer()
                    ->getContent()
                    ->setMessage('Данные успешно удалены.')
                    ->setMessageOption(['class' => 'alert alert-success', 'role' => 'alert']);
                $controller
                    ->getAnswer()
                    ->getFooter()
                    ->setElements(CollectionButtonCloseFactory::create());

                return $controller->getAnswer()->isPost();
            }
            catch (Exception $exception) {
                $transaction->rollBack();
                $controller
                    ->getAnswer()
                    ->getContent()
                    ->setMessage($exception->getMessage())
                    ->setMessageOption(['class' => 'alert alert-danger', 'role' => 'alert']);

                return $controller->getAnswer()->isDelete();
            }
        } else {
            throw new NotFoundHttpException('Request is not Ajax.');
        }
    }

    /**
     * @return bool
     */
    public function beforeRun(): bool
    {
        /** @var ApplicationController $controller */
        $controller = $this->controller;
        $controller->getAnswer()
            ->setContainerReload($controller->getForceReload())
            ->setTitle('Удаление записей');

        return true;
    }
}
