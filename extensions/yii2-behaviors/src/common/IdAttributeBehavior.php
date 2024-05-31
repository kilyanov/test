<?php

declare(strict_types=1);

namespace kilyanov\behaviors\common;

use UUID\UUID;
use yii\base\Model;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

class IdAttributeBehavior extends AttributeBehavior
{
    /**
     * @return string[]
     */
    public function events(): array
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'getValueAttribute',
        ];
    }

    /**
     * @param $event
     * @return void
     */
    public function getValueAttribute($event): void
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        $owner->id = $owner->isNewRecord ? UUID::uuid7() : $owner->id;
    }
}
