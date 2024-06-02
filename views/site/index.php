<?php

use app\modules\admin\modules\event\grid\OrganizatorColumn;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">
        <?= GridView::widget([
            'filterModel' => null,
            'dataProvider' => $dataProvider,
            'tableOptions' => Yii::$app->params['gridViewTableOptions'],
            'columns' => [
                'name',
                [
                    'attribute' => 'dateEvent',
                    'format' => 'html',
                ],
                'description',
                [
                    'class' => OrganizatorColumn::class,
                ],
            ],
            'pager' => [
                'class' => LinkPager::class,
                'options' => ['style' => 'margin-left:10px;']
            ]
        ]);
        ?>
    </div>
</div>
