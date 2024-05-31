<?php

declare(strict_types=1);

namespace kilyanov\ajax\factory;

use Exception;
use kilyanov\ajax\Answer;
use kilyanov\ajax\entity\ContentEntity;
use kilyanov\ajax\entity\FooterEntity;
use kilyanov\ajax\interfaces\AnswerFactoryInterface;
use kilyanov\ajax\interfaces\AnswerInterface;
use kilyanov\ajax\interfaces\ContentInterface;
use kilyanov\ajax\interfaces\FooterInterface;
use Yii;
use yii\helpers\ArrayHelper;

class BaseFactory implements AnswerFactoryInterface
{
    /**
     * @param array $config
     * @return AnswerInterface
     * @throws Exception
     */
    public static function create(array $config = []): AnswerInterface
    {
        $object = new Answer();
        $title = ArrayHelper::keyExists('config.title', $config);
        if ($title != null) {
            $object->setTitle((string)$title);
        }
        if (ArrayHelper::keyExists('config.content.class', $config)) {
            $contentObject = Yii::createObject(ArrayHelper::keyExists('config.content', $config));
            /** @var $contentObject ContentInterface */
            $object->setContent($contentObject);
        }
        else {
            $object->setContent(new ContentEntity());
        }
        if (ArrayHelper::keyExists('config.footer.class', $config)) {
            $footerObject = Yii::createObject(ArrayHelper::keyExists('config.footer', $config));
            /** @var $footerObject FooterInterface */
            $object->setFooter($footerObject);
        }
        else {
            $object->setFooter(new FooterEntity());
        }

        return $object;
    }
}
