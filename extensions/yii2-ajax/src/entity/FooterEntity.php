<?php

declare(strict_types=1);

namespace kilyanov\ajax\entity;

use kilyanov\ajax\interfaces\CollectionButtonFactoryInterface;
use kilyanov\ajax\interfaces\ElementInterface;
use kilyanov\ajax\interfaces\FooterInterface;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;

class FooterEntity extends BaseEntity implements FooterInterface
{
    /**
     * @var array
     */
    private array $elements = [];

    /**
     * @param ElementInterface|array $element
     * @return FooterInterface
     */
    public function setElements(ElementInterface|array $element): FooterInterface
    {
        $this->elements = [];
        if (is_array($element)) {
            foreach ($element as $item) {
                if ($item instanceof ElementInterface) {
                    $this->elements = ArrayHelper::merge($this->elements, [$item]);
                } else {
                    throw new InvalidArgumentException("Property element not ElementInterface or array");
                }
            }
        } elseif ($element instanceof ElementInterface) {
            $this->elements = ArrayHelper::merge($this->elements, [$element]);
        } else {
            throw new InvalidArgumentException("Property element not ElementInterface or array");
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        if (!empty($this->elements)) {
            return implode(
                '',
                array_map(
                    function ($element) {
                        /** @var ElementInterface $element */
                        return $element->getData();
                    },
                    $this->elements
                )
            );
        }
        return '';
    }
}
