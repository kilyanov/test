<?php

declare(strict_types=1);

use app\modules\organizator\models\Organizator;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use app\modules\event\models\Event;
use yii\widgets\MaskedInput;

/**
 * @var $model Organizator
 */
?>

<?php
$form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-3">
        <?= $form
            ->field($model, 'fio') ?>
    </div>
    <div class="col-md-3">
        <?= $form
            ->field($model, 'email') ?>
    </div>
    <div class="col-md-3">
        <?= $form
            ->field($model, 'phone')
            ->widget(MaskedInput::class, [
                'mask' => '999-999-9999',
            ]) ?>
    </div>
    <div class="col-md-3">
        <?= $form
            ->field($model, 'hidden')
            ->dropDownList($model::getHiddenList(), ['prompt' => '']) ?>
    </div>
</div>
<div class="row">
    <?= $form
        ->field($model, 'eventIds')->widget(
            Select2::class, [
            'data' => Event::asDropDown(),
            'options' => [
                'multiple' => true,
                'placeholder' => 'События',
            ],
            'pluginOptions' => [
                'closeOnSelect' => false
            ]
        ]); ?>
</div>

<?php ActiveForm::end(); ?>
