<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface ElementInterface
{
    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param array $options
     */
    public function setOptions(array $options): void;

    /**
     * @return array|null
     */
    public function getOptions(): ?array;

    /**
     * @param array $listAccess
     * @return void
     */
    public function setListAccess(array $listAccess): void;

    /**
     * @return array|null
     */
    public function getListAccess(): ?array;
}
