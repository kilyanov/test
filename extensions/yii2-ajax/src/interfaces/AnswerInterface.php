<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface AnswerInterface
{
    public const DEFAULT_FORCE_RELOAD = 'js-container-reload';

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self;

    /**
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * @param ContentInterface|null $content
     * @return self
     */
    public function setContent(?ContentInterface $content): self;

    /**
     * @return ContentInterface|null
     */
    public function getContent(): ?ContentInterface;

    /**
     * @param FooterInterface|null $footer
     * @return self
     */
    public function setFooter(?FooterInterface $footer): self;

    /**
     * @return FooterInterface|null
     */
    public function getFooter(): ?FooterInterface;

    /**
     * @param string $containerReload
     * @return self
     */
    public function setContainerReload(string $containerReload): self;

    /**
     * @return string
     */
    public function getContainerReload(): string;

    /**
     * @return array
     */
    public function isGet(): array;

    /**
     * @return array
     */
    public function isPost(): array;

    /**
     * @return array
     */
    public function isDelete(): array;
}
