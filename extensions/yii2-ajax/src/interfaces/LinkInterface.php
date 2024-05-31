<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface LinkInterface
{
    public const ABSOLUTE_LINK_NO = 0;
    public const ABSOLUTE_LINK_YES = 1;

    /**
     * @param array $url
     * @return self
     */
    public function setUrl(array $url): self;

    /**
     * @return array|null
     */
    public function getUrl(): ?array;

    /**
     * @param int $absoluteUrl
     * @return self
     */
    public function setAbsoluteUrl(int $absoluteUrl): self;

    /**
     * @return int
     */
    public function getAbsoluteUrl(): int;

    /**
     * @return bool
     */
    public function isAbsoluteUrl(): bool;
}
