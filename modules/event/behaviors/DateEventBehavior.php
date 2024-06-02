<?php

declare(strict_types=1);

namespace app\modules\event\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;

/**
 *
 * @property-read void $value
 */
class DateEventBehavior extends Behavior
{
    /**
     * @var string
     */
    public string $attribute = 'dateEvent';

    /**
     * @return string[]
     */
    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'setValue',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'setValue',
            BaseActiveRecord::EVENT_AFTER_FIND => 'getValue',
        ];
    }

    /**
     * @return void
     * @throws InvalidConfigException
     */
    public function setValue(): void
    {
        $owner = $this->owner;
        $owner->{$this->attribute} = Yii::$app->formatter->asDate($owner->{$this->attribute}, 'php:Y-m-d');
    }

    /**
     * @return void
     * @throws InvalidConfigException
     */
    public function getValue(): void
    {
        $owner = $this->owner;
        $owner->{$this->attribute} = Yii::$app->formatter->asDate($owner->{$this->attribute}, 'php:d.m.Y');
    }
}
