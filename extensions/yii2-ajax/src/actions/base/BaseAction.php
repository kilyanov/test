<?php

declare(strict_types=1);

namespace kilyanov\ajax\actions\base;

use kilyanov\ajax\controller\ApplicationController;
use kilyanov\ajax\factory\CollectionButtonCloseFactory;
use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\web\Response;

class BaseAction extends Action
{
    /**
     * @var string
     */
    protected string $template = '';

    /**
     * @var Model|null
     */
    private ?Model $model = null;

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * @param Model|null $model
     * @return void
     */
    public function setModel(?Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return void
     */
    protected function setErrorSaveData(): void
    {
        /** @var ApplicationController $controller */
        $controller = $this->controller;
        $controller
            ->getAnswer()
            ->getContent()
            ->setMessage(implode(', ', $this->getModel()->getErrorSummary(true)))
            ->setMessageOption(['class' => 'alert alert-danger', 'role' => 'alert']);
        $controller
            ->getAnswer()
            ->getFooter()
            ->setElements(CollectionButtonCloseFactory::create());
    }

    /**
     * @return array|string[]
     */
    protected function getAnswer(): array
    {
        /** @var ApplicationController $controller */
        $controller = $this->controller;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isGet) {
            return $controller->getAnswer()->isGet();
        } else if ($this->getModel()->load(Yii::$app->request->post())
            && $this->getModel()->validate()) {
            if ($this->getModel()->save()) {
                $controller
                    ->getAnswer()
                    ->getContent()
                    ->setMessage('Данные успешно сохранены.')
                    ->setMessageOption(['class' => 'alert alert-success', 'role' => 'alert']);
                $controller
                    ->getAnswer()
                    ->getFooter()
                    ->setElements(CollectionButtonCloseFactory::create());
            } else {
                $this->setErrorSaveData();
            }

            return $controller->getAnswer()->isPost();
        }
        $this->setErrorSaveData();

        return $controller->getAnswer()->isPost();
    }
}
