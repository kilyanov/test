<?php

declare(strict_types=1);

namespace kilyanov\ajax;

use kilyanov\ajax\interfaces\AnswerInterface;
use kilyanov\ajax\interfaces\ContentInterface;
use kilyanov\ajax\interfaces\FooterInterface;
use yii\base\BaseObject;

class Answer extends BaseObject implements AnswerInterface
{
    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var ContentInterface|null
     */
    private ?ContentInterface $content = null;

    /**
     * @var FooterInterface|null
     */
    private ?FooterInterface $footer = null;

    /**
     * @var string
     */
    private string $containerReload = AnswerInterface::DEFAULT_FORCE_RELOAD;

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): AnswerInterface
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param ContentInterface|null $content
     * @return self
     */
    public function setContent(?ContentInterface $content): AnswerInterface
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return ContentInterface|null
     */
    public function getContent(): ?ContentInterface
    {
        return $this->content;
    }

    /**
     * @param FooterInterface|null $footer
     * @return self
     */
    public function setFooter(?FooterInterface $footer): AnswerInterface
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * @return FooterInterface|null
     */
    public function getFooter(): ?FooterInterface
    {
        return $this->footer;
    }

    /**
     * @param string $containerReload
     * @return self
     */
    public function setContainerReload(string $containerReload): AnswerInterface
    {
        $this->containerReload = $containerReload;

        return $this;
    }

    /**
     * @return string
     */
    public function getContainerReload(): string
    {
        return $this->containerReload;
    }

    /**
     * @return array
     */
    public function isGet(): array
    {
        return [
            'title' => $this->getTitle(),
            'content' => $this->getContent()->getData(),
            'footer' => $this->getFooter()->getData()
        ];
    }

    /**
     * @return array
     */
    public function isPost(): array
    {
        return [
            'forceReload' => '#' . $this->getContainerReload(),
            'title' => $this->getTitle(),
            'content' => $this->getContent()->getData(),
            'footer' => $this->getFooter()->getData()
        ];
    }

    /**
     * @return array
     */
    public function isDelete(): array
    {
        return [
            'forceClose' => true,
            'forceReload' => '#' . $this->getContainerReload()
        ];
    }
}
