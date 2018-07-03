<?php

declare(strict_types=1);

/**
 * @copyright  Copyright (c) 2018, Net Inventors GmbH
 * @category   peggy
 * @author     hrombach
 */

namespace Hero\Bundle\JsonValidation\Exception;

final class JsonValidationFailedException extends JsonValidationException
{
    /**
     * @var array
     */
    private $validationErrors = [];

    public static function withErrors(array $validationErrors)
    {
        return (new self(
            self::MESSAGE_VALIDATION_FAILED,
            self::CODE_VALIDATION_FAILED
        ))->setValidationErrors($validationErrors);
    }

    private function setValidationErrors(array $validationErrors): self
    {
        $this->validationErrors = $validationErrors;

        return $this;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}