<?php

declare(strict_types=1);

namespace kilyanov\ajax\entity;

use kilyanov\ajax\interfaces\ContentInterface;
use Yii;
use yii\bootstrap5\Html;

class ContentEntity extends BaseEntity implements ContentInterface
{
    /**
     * @var string|null
     */
    private ?string $template;

    /**
     * @var array
     */
    private array $params = [];

    /**
     * @var string|null
     */
    private ?string $message = null;

    /**
     * @var array
     */
    private array $messageOption = [];

    /**
     * @param string $template
     * @return self
     */
    public function setTemplate(string $template): ContentInterface
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @param array $params
     * @return self
     */
    public function setParams(array $params = []): ContentInterface
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $message
     * @return ContentInterface
     */
    public function setMessage(string $message): ContentInterface
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param array $messageOption
     * @return self
     */
    public function setMessageOption(array $messageOption): ContentInterface
    {
        $this->messageOption = $messageOption;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getMessageOption(): ?array
    {
        return $this->messageOption;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        if (!empty($this->template) && $this->message === null) {
            return Yii::$app->controller->renderAjax($this->template, $this->params);
        }
        else {
            return Html::tag(
                'div',
                $this->getMessage(),
                $this->getMessageOption()
            );
        }
    }
}
