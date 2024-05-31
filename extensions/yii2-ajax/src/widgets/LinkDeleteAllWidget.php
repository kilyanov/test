<?php

declare(strict_types=1);

namespace kilyanov\ajax\widgets;

use Exception;
use kilyanov\ajax\entity\UrlEntity;
use kilyanov\ajax\interfaces\ElementInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Widget;
use yii\helpers\ArrayHelper;

class LinkDeleteAllWidget extends Widget
{
    /**
     * @var array
     */
    public array $access = [];

    /**
     * @var array
     */
    protected array $button = [];

    /**
     * @return void
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function init(): void
    {
        parent::init();
        $this->button = [
            new UrlEntity([
                'name' => 'Удалить выбранные',
                'url' => ['delete-all'],
                'options' => [
                    'class' => 'btn btn-danger',
                    'role' => 'modal-remote-bulk',
                    'data-confirm' => false,
                    'data-method' => false,
                    'data-request-method' => 'post',
                    'data-confirm-title' => 'Подтверждение удаления!',
                    'data-confirm-message' => 'Вы уверены что хотите удалить выбранные записи?'
                ],
                'listAccess' => ArrayHelper::getValue(
                    $this->access,
                    'delete-all',
                    Yii::$app->controller->getListAccess())
            ]),
        ];
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return implode(
            '',
            array_map(
                function ($button) {
                    /** @var ElementInterface $button */
                    return $button->getData();
                },
                $this->button
            )
        );
    }

}
