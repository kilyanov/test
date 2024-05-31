<?php

declare(strict_types=1);

namespace kilyanov\ajax\entity;

use kilyanov\ajax\interfaces\LinkInterface;
use Yii;
use yii\base\InvalidArgumentException;
use yii\bootstrap5\Html;

class UrlEntity extends ElementEntity implements LinkInterface
{
    /**
     * @var array
     */
    private array $url;

    /**
     * @var int
     */
    private int $absoluteUrl = LinkInterface::ABSOLUTE_LINK_NO;

    /**
     * @param array $url
     * @return self
     */
    public function setUrl(array $url): LinkInterface
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getUrl(): ?array
    {
        return $this->url;
    }

    /**
     * @param int $absoluteUrl
     * @return self
     */
    public function setAbsoluteUrl(int $absoluteUrl): self
    {
        $this->absoluteUrl = $absoluteUrl;

        return $this;
    }

    /**
     * @return int
     */
    public function getAbsoluteUrl(): int
    {
        return $this->absoluteUrl;
    }

    /**
     * @return bool
     */
    public function isAbsoluteUrl(): bool
    {
        return $this->absoluteUrl === LinkInterface::ABSOLUTE_LINK_YES;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        if (!$this->isAccess() || !$this->isVisible()) {
            return '';
        }
        if ($this->getUrl() === null) {
            throw new InvalidArgumentException("Property url not set.");
        }

        $url = $this->isAbsoluteUrl() ?
            Yii::$app->getUrlManager()->createAbsoluteUrl($this->getUrl(), true) : $this->getUrl();

        return Html::a($this->getName(), $url, $this->getOptions());
    }
}
