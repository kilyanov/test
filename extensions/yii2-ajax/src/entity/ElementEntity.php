<?php

declare(strict_types=1);

namespace kilyanov\ajax\entity;

use kilyanov\ajax\interfaces\ElementInterface;
use Yii;
use yii\base\BaseObject;

/**
 *
 * @property-read string $data
 */
abstract class ElementEntity extends BaseObject implements ElementInterface
{
    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var array
     */
    private array $options = [];

    /**
     * @var array
     */
    private array $listAccess = [];

    /**
     * @var bool
     */
    private bool $visible = true;

    /**
     * @return string
     */
    abstract function getData(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param array $options
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return array|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param array $listAccess
     * @return void
     */
    public function setListAccess(array $listAccess): void
    {
        $this->listAccess = $listAccess;
    }

    /**
     * @return array|null
     */
    public function getListAccess(): ?array
    {
        return $this->listAccess;
    }

    /**
     * @return bool
     */
    public function isAccess(): bool
    {
        foreach ($this->listAccess as $access) {
            if (!Yii::$app->user->can($access)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     * @return void
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }
}
