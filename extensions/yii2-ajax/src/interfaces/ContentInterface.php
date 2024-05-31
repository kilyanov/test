<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface ContentInterface
{
    /**
     * @param string $template
     * @return self
     */
    public function setTemplate(string $template): self;

    /**
     * @return string|null
     */
    public function getTemplate(): ?string;

    /**
     * @param array $params
     * @return self
     */
    public function setParams(array $params = []): self;

    /**
     * @return array
     */
    public function getParams(): array;

    /**
     * @param string $message
     * @return self
     */
    public function setMessage(string $message): self;

    /**
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * @param array $messageOption
     * @return self
     */
    public function setMessageOption(array $messageOption): self;

    /**
     * @return array|null
     */
    public function getMessageOption(): ?array;
}
