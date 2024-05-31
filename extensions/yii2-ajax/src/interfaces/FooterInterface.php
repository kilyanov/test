<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface FooterInterface
{
    /**
     * @param ElementInterface|array $element
     * @return self
     */
    public function setElements(ElementInterface|array $element): self;

    /**
     * @return array
     */
    public function getElements(): array;
}
