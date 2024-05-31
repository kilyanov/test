<?php

declare(strict_types=1);

namespace kilyanov\ajax\controller;

use kilyanov\ajax\actions\base\CreateAction;
use kilyanov\ajax\actions\base\DeleteAction;
use kilyanov\ajax\actions\base\DeleteAllAction;
use kilyanov\ajax\actions\base\ExportAction;
use kilyanov\ajax\actions\base\ImportAction;
use kilyanov\ajax\actions\base\IndexAction;
use kilyanov\ajax\actions\base\MovingAction;
use kilyanov\ajax\actions\base\UpdateAction;
use kilyanov\ajax\interfaces\AnswerInterface;
use League\Tactician\CommandBus;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @property-read array $exportAttribute
 */
class ApplicationController extends Controller implements ControllerInterface
{
    const TYPE_RENDER_DEFAULT = 'render';
    const TYPE_RENDER_PARTIAL = 'renderPartial';

    /**
     * @var CommandBus
     */
    protected CommandBus $bus;

    /**
     * @var AnswerInterface
     */
    protected AnswerInterface $answer;

    /**
     * @var array
     */
    private array $listAccess = [];

    /**
     * @var string
     */
    private string $modelClass;

    /**
     * @var array
     */
    private array $cfgModel = [];

    /**
     * @var string
     */
    protected string $searchModelClass;

    /**
     * @var array
     */
    private array $cfgSearchModel = [];

    /**
     * @var string
     */
    private string $forceReload = AnswerInterface::DEFAULT_FORCE_RELOAD;

    /**
     * @var string
     */
    protected string $typeRender = self::TYPE_RENDER_DEFAULT;

    /**
     * @param $id
     * @param $module
     * @param CommandBus $bus
     * @param AnswerInterface $answer
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        CommandBus $bus,
        AnswerInterface $answer,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->bus = $bus;
        $this->answer = $answer;
    }

    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->listAccess,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function actions(): array
    {
        return [
            'index' => [
                'class' => IndexAction::class,
            ],
            'create' => [
                'class' => CreateAction::class,
            ],
            'update' => [
                'class' => UpdateAction::class,
            ],
            'delete' => [
                'class' => DeleteAction::class,
            ],
            'delete-all' => [
                'class' => DeleteAllAction::class,
            ],
            'move' => [
                'class' => MovingAction::class,
            ],
            'export' => [
                'class' => ExportAction::class,
            ],
            'import' => [
                'class' => ImportAction::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getListAccess(): array
    {
        return $this->listAccess;
    }

    /**
     * @param array $listAccess
     * @param bool $clear
     * @return void
     */
    public function setListAccess(array $listAccess, bool $clear = true): void
    {
        $this->listAccess = $clear ? $listAccess : ArrayHelper::merge($this->listAccess, $listAccess);
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * @param string $modelClass
     * @return void
     */
    public function setModelClass(string $modelClass): void
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @return array
     */
    public function getCfgModel(): array
    {
        return $this->cfgModel;
    }

    /**
     * @param array $cfgModel
     * @return void
     */
    public function setCfgModel(array $cfgModel): void
    {
        $this->cfgModel = ArrayHelper::merge($this->cfgModel, $cfgModel);
    }

    /**
     * @return string
     */
    public function getSearchModelClass(): string
    {
        return $this->searchModelClass;
    }

    /**
     * @param string $searchModelClass
     * @return void
     */
    public function setSearchModelClass(string $searchModelClass): void
    {
        $this->searchModelClass = $searchModelClass;
    }

    /**
     * @return array
     */
    public function getCfgSearchModel(): array
    {
        return $this->cfgSearchModel;
    }

    /**
     * @param array $cfgSearchModel
     * @return void
     */
    public function setCfgSearchModel(array $cfgSearchModel): void
    {
        $this->cfgSearchModel = ArrayHelper::merge($this->cfgSearchModel, $cfgSearchModel);
    }

    /**
     * @return string
     */
    public function getForceReload(): string
    {
        return $this->forceReload;
    }

    /**
     * @param string $forceReload
     * @return void
     */
    public function setForceReload(string $forceReload): void
    {
        $this->forceReload = $forceReload;
    }

    /**
     * @return string
     */
    public function getTypeRender(): string
    {
        return $this->typeRender;
    }

    /**
     * @param string $typeRender
     * @return void
     */
    public function setTypeRender(string $typeRender): void
    {
        $this->typeRender = $typeRender;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findModel(string $id)
    {
        $class = $this->modelClass;
        /** @var ActiveRecord $class */
        $query = $class::find()->ids($id);
        if ($query->hasMethod('hidden')) {
            $query->hidden();
        }
        $model = $query->one();
        if (!$model instanceof ActiveRecord) {
            throw new NotFoundHttpException("Records with ID {$id} not found.");
        }

        return $model;
    }

    /**
     * @return AnswerInterface
     */
    public function getAnswer(): AnswerInterface
    {
        return $this->answer;
    }

    /**
     * @return array
     */
    public function getExportAttribute(): array
    {
        return [];
    }
}
