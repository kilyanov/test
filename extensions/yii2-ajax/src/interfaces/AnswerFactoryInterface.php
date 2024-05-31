<?php

declare(strict_types=1);

namespace kilyanov\ajax\interfaces;

interface AnswerFactoryInterface
{
    /**
     * @param array $config
     * @return AnswerInterface
     */
    public static function create(array $config): AnswerInterface;
}
