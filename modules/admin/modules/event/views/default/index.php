<?php

declare(strict_types=1);

use app\modules\admin\modules\event\grid\OrganizatorColumn;
use kilyanov\ajax\grid\ActionColumn;
use kilyanov\ajax\grid\HiddenColumn;
use kilyanov\ajax\widgets\GroupButtonWidget;
use kilyanov\ajax\widgets\LinkDeleteAllWidget;
use kilyanov\ajax\widgets\ModalWidget;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

/**
 * @var ActiveQuery $model
 * @var ActiveDataProvider $dataProvider
 * @var string $forceReload
 * @var array $listAccess
 */

$this->title = 'События';

$this->params['breadcrumbs'][] = $this->title;

?>

<?= GroupButtonWidget::widget(['access' => $listAccess]) ?>

<?php Pjax::begin(['id' => $forceReload]); ?>
<?= GridView::widget([
    'filterModel' => $model,
    'dataProvider' => $dataProvider,
    'tableOptions' => Yii::$app->params['gridViewTableOptions'],
    'columns' => [
        [
            'headerOptions' => ['style' => 'width:20px'],
            'class' => CheckboxColumn::class,
        ],
        [
            'class' => ActionColumn::class,
        ],
        'name',
        [
            'attribute' => 'dateEvent',
            'filter' => DatePicker::widget([
                'model'=> $model,
                'attribute'=>'dateEvent',
                'language' => 'ru',
                'dateFormat' => 'dd.MM.yyyy',
            ]),
            'format' => 'html',
        ],
        'description',
        [
            'class' => OrganizatorColumn::class,
        ],
        [
            'class' => HiddenColumn::class,
        ],
    ],
    'pager' => [
        'class' => LinkPager::class,
        'options' => ['style' => 'margin-left:10px;']
    ]
]);
?>
<?php Pjax::end(); ?>

<?= LinkDeleteAllWidget::widget(['access' => $listAccess]) ?>

<?= ModalWidget::widget() ?>
