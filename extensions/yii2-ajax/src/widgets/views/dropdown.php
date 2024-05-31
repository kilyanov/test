<?php

use UUID\UUID;
use yii\bootstrap5\Dropdown;
use yii\bootstrap5\Html;

/**
 * @var string $label
 * @var array $items
 */
?>
<div class="dropdown">
    <?= Html::a(
        $label,
        '#',
        [
            'data-bs-toggle' => 'dropdown',
            'class' => 'btn btn-default dropdown-toggle',
            'aria-expanded' => false
        ]
    ) ?>
    <?= Dropdown::widget([
        'items' => $items,
        'id' => UUID::uuid7()
    ]) ?>
</div>
