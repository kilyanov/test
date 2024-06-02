<?php

declare(strict_types=1);

use app\modules\organizator\models\Organizator;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use app\modules\event\models\Event;
use yii\helpers\ArrayHelper;

/**
 * @var $model Event
 */

?>
<?php
$form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-4">
        <?= $form
            ->field($model, 'name') ?>
    </div>
    <?=
    $form->field($model, 'dateEvent', [
        'options' => ['class' => 'form-group col-md-4']])
        ->widget(
            DatePicker::class, [
            'options' => ['placeholder' => 'Дата...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy'
            ]
        ]);
    ?>
    <div class="col-md-4">
        <?= $form
            ->field($model, 'hidden')
            ->dropDownList($model::getHiddenList(), ['prompt' => '']) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form
            ->field($model, 'description')->textarea()
        ?>
    </div>
</div>
<div class="row">
    <?= $form
        ->field($model, 'organizationIds')->widget(
            Select2::class, [
            'data' => Organizator::asDropDown(),
            'options' => [
                'multiple' => true,
                'placeholder' => 'Организаторы',
            ],
            'pluginOptions' => [
                'closeOnSelect' => false
            ]
        ]); ?>
</div>

<?php ActiveForm::end(); ?>
